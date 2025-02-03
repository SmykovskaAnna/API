<?php

namespace App\Repository;

use App\Entity\Currency;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Currency>
 */
class CurrencyRepository extends ServiceEntityRepository
{

    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Currency::class);
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function getAll(array $data): mixed
    {
        $queryBuilder = $this->createQueryBuilder("currency");

        if (isset($data['asset'])) {
            $queryBuilder->andWhere("currency.asset = :currency")
                ->setParameter("currency", $data['asset']);
        }

        return $queryBuilder->getQuery()->getResult();
    }

}
