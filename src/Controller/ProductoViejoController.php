<?php

namespace App\Controller;

use App\Entity\Producto;
use App\Repository\ProductoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductoViejoController extends AbstractController
{
    /**
     * @Route("/", name="productos_index")
     */
    public function index(ProductoRepository $productoRepository): Response
    {
//        $productos = $this->getDoctrine()
//            ->getRepository(Producto::class)
//            ->findAll();
        $productos = $productoRepository->findAll();



        return $this->render('producto/indexViejo.html.twig', [
            'productos' => $productos,
        ]);
    }

    /**
     * @Route("producto/{id}", name="productos_show")
     */
    public function show(Producto $producto): Response
    {
        return $this->render('producto/showViejo.html.twig', [
            'producto' => $producto,
        ]);
    }
}
