<?php

namespace App\Services\Product;

use App\Entity\Product;
use App\Services\RequestCheckerService;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
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
     * @param string $name
     * @param string $description
     * @param string $price
     * @param string $slug
     * @return Product
     */
    public function createProduct(
        string $name,
        string $description,
        string $price,
        string $slug
    ): Product {

        $product = $this->createProductObject($name, $description, $price, $slug);

        $this->requestCheckerService->validateRequestDataByConstraints($product);

        $this->entityManager->persist($product);

        return $product;
    }

    /**
     * @param string $name
     * @param string $description
     * @param string $price
     * @param string $slug
     * @return Product
     */
    private function createProductObject(
        string $name,
        string $description,
        string $price,
        string $slug
    ): Product {
        $product = new Product();

        $product
            ->setName($name)
            ->setDescription($description)
            ->setPrice($price)
            ->setSlug($slug);

        return $product;
    }

    /**
     * @param Product $product
     * @param array $data
     * @return void
     */
    public function updateProduct(Product $product, array $data): void
    {
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst(strtolower($key));

            if (!method_exists($product, $method)) {
                continue;
            }

            $product->$method($value);
        }

        $this->requestCheckerService->validateRequestDataByConstraints($product);

    }

}