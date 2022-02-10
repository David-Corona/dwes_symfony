<?php
// Logica de negocio

namespace App\BLL;

// configurar el servicio -> services.yaml, con argunentos = propiedades

use App\Repository\ProductoRepository;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class ProductoBLL
{
    private RequestStack $requestStack;
    private ProductoRepository $productoRepository;
    private Security $security;

    // inyectamos en este servicio directamente, en vez inyectar en action y pasar aquí
    public function __construct(RequestStack $requestStack, ProductoRepository $productoRepository, Security $security)
    {
        $this->requestStack = $requestStack;
        $this->productoRepository = $productoRepository;
        $this->security = $security;
    }

    public function getProductosConOrdenacion(?string $ordenacion)
    {
        if (!is_null($ordenacion)) {
            $tipoOrdenacion = 'asc';
            $session = $this->requestStack->getSession();
            $productosOrdenacion = $session->get('productosOrdenacion');
            if (!is_null($productosOrdenacion)) {
                if ($productosOrdenacion['ordenacion'] === $ordenacion) {
                    if ($productosOrdenacion['tipoOrdenacion'] === 'asc')
                        $tipoOrdenacion = 'desc';
                }
            }
            $session->set('productosOrdenacion', [ 'ordenacion' => $ordenacion, 'tipoOrdenacion' => $tipoOrdenacion ]);
        } else {
            $ordenacion = 'id';
            $tipoOrdenacion = 'asc';
        }
        // findBy recibe 2 arrays: criterios búsqueda y criterios ordenación
        // $productos = $productoRepository->findBy([], [$ordenacion => $tipoOrdenacion]); // Ejecutaba otra querie por cada categoria

        // Para mostrar productos del usuario
        $usuarioLogueado = $this->security->getUser();
        return $this->productoRepository->findProductosConCategoria($ordenacion, $tipoOrdenacion, $usuarioLogueado);

    }

}