<?php
// Logica de negocio

namespace App\BLL;

// configurar el servicio -> services.yaml, con argunentos = propiedades

use App\Repository\ProductoRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class ProductoBLL
{
    private RequestStack $requestStack;
    private ProductoRepository $productoRepository;

    // inyectamos en este servicio directamente, en vez inyectar en action y pasar aquí
    public function __construct(RequestStack $requestStack, ProductoRepository $productoRepository)
    {
        $this->requestStack = $requestStack;
        $this->productoRepository = $productoRepository;
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

        return $this->productoRepository->findProductosConCategoria($ordenacion, $tipoOrdenacion);

    }

}