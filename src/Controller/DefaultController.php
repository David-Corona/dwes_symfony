<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    //php bin/console debug:router <- ver listado rutas.
    //Siempre establecer un nombre para la ruta.

    /**
     * @Route("/", name="dwes_index")
     */
    public function index()
    {
        $nombre = 'David';
        $users = ['Pepe', 'Jose', 'Eustaquio'];
        return $this->render('hola-mundo.html.twig', ['nombre' => $nombre, 'users' => $users]);
    }
}