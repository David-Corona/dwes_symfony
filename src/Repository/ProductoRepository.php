<?php

namespace App\Repository;

use App\Entity\Producto;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use function Doctrine\ORM\QueryBuilder;

/**
 * @method Producto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Producto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Producto[]    findAll()
 * @method Producto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Producto::class);
    }

    /**
    * @return Producto[]
    */
    public function findProductos(?string $titulo, ?string $fechaInical, ?string $fechaFinal, string $categoria)
    {

        $qb = $this->createQueryBuilder('producto'); // alias p = el objeto en la clase en la que estoy

        if (!is_null($categoria) && $categoria !== '') {
            $qb->innerJoin('producto.categoria', 'categoria');
            $qb->andWhere(
                $qb->expr()->like('categoria.nombre', ':categoria'), // where titulo equivale al parametro
            )->setParameter('categoria', '%'.$categoria.'%'); //doy valor al parametro
        }


        if (!is_null($titulo) && $titulo !== '') {
            $qb->andWhere(
                $qb->expr()->orX(
                    $qb->expr()->like('producto.titulo', ':val'), // where titulo equivale al parametro
                    $qb->expr()->like('producto.descripcion', ':val') // o a la descripcion
                )
            )->setParameter('val', '%'.$titulo.'%'); //doy valor al parametro
        }

        if (!is_null($fechaInical) && $fechaInical !== '') {
            $dtFechaInicial = DateTime::createFromFormat('Y-m-d', $fechaInical);
            $qb ->andWhere($qb->expr()->gte('producto.fecha', ':fechaInicial'))
            ->setParameter('fechaInicial', $dtFechaInicial);
        }

        if (!is_null($fechaFinal) && $fechaFinal !== '') {
            $dtFechaIFinal = DateTime::createFromFormat('Y-m-d', $fechaFinal);
            $qb ->andWhere($qb->expr()->lte('producto.fecha', ':fechaFinal'))
                ->setParameter('fechaFinal', $dtFechaIFinal);
        }




        return $qb->getQuery()->getResult();

    }

    // para cargar datos de distintas tablas -> query multitabla

    /**
     * @param string $ordenacion
     * @param string $tipoOrdenacion
     * @return int|mixed|string
     */
    public function findProductosConCategoria(string $ordenacion, string $tipoOrdenacion)
    {
        $qb = $this->createQueryBuilder('producto'); //creo query para entienda producto

        $qb->addSelect('categoria')
            ->innerJoin('producto.categoria', 'categoria') // extrae datos de las 2 tablas = where x.id=y.id
            ->orderBy('producto.'.$ordenacion, $tipoOrdenacion);

        return $qb->getQuery()->getResult();
    }


    // /**
    //  * @return Producto[] Returns an array of Producto objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Producto
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
