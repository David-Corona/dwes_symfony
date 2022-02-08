<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Form\ProductoType;
use App\Repository\ProductoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/producto/admin")
 */
class ProductoController extends AbstractController
{
    /**
     * @Route("/", name="producto_index", methods={"GET"})
     */
    public function index(ProductoRepository $productoRepository): Response
    {
        return $this->render('producto/index.html.twig', [
            'productos' => $productoRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="producto_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Request: permite acceder a to-do aquello que venga por get/post/$_Server
        // entityManager: entidades interactuan con bbdd mediante entitymanager
        $producto = new Producto();
        //Para añadir campos por defecto -> generar constructor en la clase -> creado con ejemplo imagen por defecto
        //En otra parte, donde ya esté inicalizado, podría modificarlo: $producto->setImagen()
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request); //recoge lo recibido por post y lo introduce dentro de $producto

        // verifica si se han enviado datos (entra al if) o simplemente muestra el formulario (no entra)
        if ($form->isSubmitted() && $form->isValid()) {

            // $imagen almacena la imagen subida
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $imagen */
            $imagen = $form['imagen']->getData();

            // Se genera un nombre único
            $fileName = md5(uniqid()).'.'.$imagen->guessExtension();

            // Mueve la imagen al directorio de imágenes
            $imagen->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            // cambiamos el campo imagen del producto para almacenar el nombre del fichero
            $producto->setImagen($fileName);


            $entityManager->persist($producto); //genera la query, el insert para guardar en bbdd
            $entityManager->flush(); //se ejecuta en bbdd, ejecuta queries pendientes

            return $this->redirectToRoute('producto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('producto/new.html.twig', [
            'producto' => $producto,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="producto_show", methods={"GET"})
     */
    public function show(Producto $producto): Response
    {
        return $this->render('producto/show.html.twig', [
            'producto' => $producto,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="producto_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Producto $producto, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProductoType::class, $producto); //inyecta el producto cogido de bbdd mediante id
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /**
             * @var Symfony\Component\HttpFoundation\File\UploadedFile $imagen
             */
            $imagen = $form['imagen']->getData();

            // Se genera un nombre único
            $fileName = md5(uniqid()).'.'.$imagen->guessExtension();

            // Mueve la imagen al directorio de imágenes
            $imagen->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            // cambiamos el campo imagen del producto para almacenar el nombre del fichero
            $producto->setImagen($fileName);




            $entityManager->flush();

            return $this->redirectToRoute('producto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('producto/edit.html.twig', [
            'producto' => $producto,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="producto_delete", methods={"POST"})
     */
    public function delete(Request $request, Producto $producto, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$producto->getId(), $request->request->get('_token'))) {
            $entityManager->remove($producto);
            $entityManager->flush();
        }

        return $this->redirectToRoute('producto_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}", name="producto_delete_json", methods={"DELETE"})
     */
    public function deleteJson(Producto $producto, EntityManagerInterface $entityManager): Response
    {

        $entityManager->remove($producto);
        $entityManager->flush();

        // en vez de redirigir, devolvemos respuesta JSON con booleano true
        return new JsonResponse(['eliminado' => true ]);
    }
}
