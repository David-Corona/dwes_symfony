<?php

namespace App\Controller\CRUD;

use App\BLL\ProductoBLL;
use App\Entity\Producto;
use App\Form\ProductoType;
use App\Repository\ProductoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/producto")
 */
class ProductoController extends AbstractController
{

    /**
     * @Route("/", name="producto_index", methods={"GET"})
     * @Route("/orden/{ordenacion}", name="producto_index_ordenado", methods={"GET"})
     */
    public function index(ProductoBLL $productoBLL, string $ordenacion=null): Response
    {
        $productos = $productoBLL->getProductosConOrdenacion($ordenacion);
        return $this->render('producto/index.html.twig', [
            'productos' => $productos,
        ]);
    }

    /**
     * @Route("/busqueda", name="producto_index_busqueda", methods={"POST"})
     */
    public function busqueda(Request $request, ProductoRepository $productoRepository): Response
    {
        // Separar en varios actions?? Filtrado fecha y por nombre -> nombre cambiar a categoria segun enunciado
        // o separar func repositorio

        $titulo = $request->request->get('busqueda');
        $fechaInicial = $request->request->get('fechaInicial');
        $fechaFinal = $request->request->get('fechaFinal');
        $categoria = $request->request->get('categoria');
        $usuarioLogueado = $this->getUser();
        //$productos = $productoRepository->findBy(['titulo' => $busqueda]); // busqueda del valor exacto
        $productos = $productoRepository->findProductos($titulo, $fechaInicial, $fechaFinal, $categoria, $usuarioLogueado);

        // paso las busquedas para que se guarden despues de la busqueda
        return $this->render('producto/index.html.twig', [
            'productos' => $productos,
            'titulo' => $titulo,
            'fechaInicial' => $fechaInicial,
            'fechaFinal' => $fechaFinal,
            'categoria' => $categoria,
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

        // asigna fecha de hoy por defecto
        $producto->setFecha(new \DateTime(date('Y/m/d')));

        //Para a??adir campos por defecto -> generar constructor en la clase -> creado con ejemplo imagen por defecto
        //En otra parte, donde ya est?? inicalizado, podr??a modificarlo: $producto->setImagen()
        $form = $this->createForm(ProductoType::class, $producto);
        $form->handleRequest($request); //recoge lo recibido por post y lo introduce dentro de $producto

        // verifica si se han enviado datos (entra al if) o simplemente muestra el formulario (no entra)
        if ($form->isSubmitted() && $form->isValid()) {

            // IMAGEN
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $imagen */
            $imagen = $form['imagen']->getData();

            $fileName = md5(uniqid()).'.'.$imagen->guessExtension(); // Se genera un nombre ??nico

            // Mueve la imagen al directorio de im??genes
            $imagen->move(
                $this->getParameter('images_directory'),
                $fileName
            );

            $producto->setImagen($fileName); // almacena el nombre del fichero

            //USUARIO
            $usuario = $this->getUser();
            $producto->setUsuario($usuario);

            $entityManager->persist($producto); //genera la query, el insert para guardar en bbdd
            $entityManager->flush(); //se ejecuta en bbdd, ejecuta queries pendientes

            $this->addFlash('mensaje', 'Se ha creado el producto ' . $producto->getTitulo() . ' correctamente.');

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

            // Se genera un nombre ??nico
            $fileName = md5(uniqid()).'.'.$imagen->guessExtension();

            // Mueve la imagen al directorio de im??genes
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
