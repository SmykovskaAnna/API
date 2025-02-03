<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;
use JetBrains\PhpStorm\ArrayShape;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return mixed
     */
    public function getSumOfAllProducts(): mixed
    {
        $queryBuilder = $this->createQueryBuilder("product")
            ->select("SUM(product.price) as sumOfAllProducts");

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    /**
     * @param array $data
     * @param int $itemsPerPage
     * @param int $page
     * @return mixed
     */
    #[ArrayShape([
        'products'       => "mixed",
        'totalPageCount' => "float",
        'totalItems'     => "int"
    ])] public function getAllProductsByFilter(array $data, int $itemsPerPage, int $page): array
    {
        $queryBuilder = $this->createQueryBuilder('product');

        if (isset($data['name'])) {
            $queryBuilder->andWhere('product.name LIKE :name')
                ->setParameter('name', '%' . $data['name'] . '%');
        }

        $paginator = new Paginator ($queryBuilder);
        $totalItems = count($paginator);
        $pagesCount = ceil($totalItems / $itemsPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemsPerPage * ($page - 1))
            ->setMaxResults($itemsPerPage);

        return [
            'products'       => $paginator->getQuery()->getResult(),
            'totalPageCount' => $pagesCount,
            'totalItems'     => $totalItems
        ];
    }

}
