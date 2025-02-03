<?php

namespace App\Services\TestOrder;

use App\Entity\TestOrder;
use App\Entity\User;
use App\Services\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;

class TestOrderService
{

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $entityManager;

    /**
     * @var RequestCheckerService
     */
    private RequestCheckerService $requestCheckerService;

    /**
     * @param EntityManagerInterface $entityManager
     * @param RequestCheckerService $requestCheckerService
     */
    public function __construct(
        EntityManagerInterface $entityManager,
        RequestCheckerService  $requestCheckerService
    ) {
        $this->entityManager = $entityManager;
        $this->requestCheckerService = $requestCheckerService;
    }

    /**
     * @param string $amount
     * @param User $user
     * @return TestOrder
     */
    public function createTestOrderObject(string $amount, User $user): TestOrder
    {
        $testOrder = new TestOrder();

        $testOrder
            ->setAmount($amount)
            ->setUser($user);

        $this->requestCheckerService->validateRequestDataByConstraints($testOrder);

        $this->entityManager->persist($testOrder);

        return $testOrder;
    }

}