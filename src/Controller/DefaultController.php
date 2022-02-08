<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    //php bin/console debug:router <- ver listado rutas.
    //Siempre establecer un nombre para la ruta.

    /**
     * @Route("/testeo", name="dwes_testeo")
     */
    public function testeo()
    {
        $nombre = 'David';
        $users = ['Pepe', 'Jose', 'Eustaquio'];
        return $this->render('hola-mundo.html.twig', [
            'nombre' => $nombre,
            'users' => $users,
            'fecha' => new \DateTime()
        ]);
        // Layouts, herencia plantillas
//        return $this->render('layout.html.twig', [
//            'nombre' => $nombre,
//            'users' => $users,
//            'fecha' => new \DateTime()
//        ]);
    }

    /**
     * @Route("/about", name="dwes_about")
     */
    public function about()
    {
        return $this->render('about.html.twig');
    }

    /**
     * @Route("/productos", name="dwes_index")
     */
    public function index()
    {
        $productos = [
            array(
                "titulo" => "BULLPADEL VERTEX 03 21",
                "subtitulo" => "La joya de Maxi Sánchez",
                "precio" => 274.95
            ),
            array(
                "titulo" => "MOCHILA BULLPADEL BPM-21004",
                "subtitulo" => "MID 005 negro verde",
                "precio" => 25.46
            ),
            array(
                "titulo" => "BOLAS BLACK CROWN PRO",
                "subtitulo" => "Pack 3 botes",
                "precio" => 14.50
            )
        ];

        return $this->render('index.html.twig', ['productos' => $productos]);
    }

}