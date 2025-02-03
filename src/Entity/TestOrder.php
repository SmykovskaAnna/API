<?php

namespace App\Entity;

//use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TestOrderRepository;
use Doctrine\ORM\Mapping as ORM;
use JetBrains\PhpStorm\ArrayShape;
//use Symfony\Component\Serializer\Annotation\Groups;

//#[ApiResource(
//    collectionOperations: [
//        'get'  => [
//            'method'                => 'GET',
//            'normalization_context' => ['groups' => 'get:collection:test-order']
//        ],
//        'post' => [
//            'method'                  => 'POST',
//            'denormalization_context' => ['groups' => 'post:collection:test-order'],
//            'normalization_context'   => ['groups' => 'get:item:test-order']
//        ]
//    ],
//    itemOperations: [
//        'get'    => [
//            'method'                => 'GET',
//            'normalization_context' => ['groups' => 'get:item:test-order']
//        ],
//        'patch'  => [
//            'method'                  => 'PATCH',
//            'denormalization_context' => ['groups' => 'patch:item:test-order'],
//            'normalization_context'   => ['groups' => 'get:item:test-order']
//        ],
//        'delete' => [
//            'method' => 'DELETE'
//        ],
//    ]
//)]
#[ORM\Entity(repositoryClass: TestOrderRepository::class)]
class TestOrder implements \JsonSerializable
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
//    #[Groups([
//        'get:collection:test-order',
//        'get:item:test-order'
//    ])]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    private User $user;

    #[ORM\Column(type: "decimal")]
//    #[Groups([
//        'get:collection:test-order',
//        'get:item:test-order',
//        'post:collection:test-order'
//    ])]
    private string $amount;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getAmount(): string
    {
        return $this->amount;
    }

    /**
     * @param string $amount
     * @return $this
     */
    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return array
     */
    #[ArrayShape([
        "id"     => "int|null",
        "user"   => "null|string",
        "amount" => "string"
    ])]
    public function jsonSerialize(): array
    {
        return [
            "id"     => $this->getId(),
            "user"   => $this->getUser()->getEmail(),
            "amount" => $this->getAmount()
        ];
    }
}
