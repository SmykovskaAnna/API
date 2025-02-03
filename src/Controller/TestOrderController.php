<?php
//
//namespace App\Controller;
//
//use App\Entity\User;
//use App\Services\RequestCheckerService;
//use App\Services\TestOrder\TestOrderService;
//use Doctrine\ORM\EntityManagerInterface;
//use Exception;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\JsonResponse;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Attribute\Route;
//use Symfony\Component\Security\Http\Attribute\IsGranted;
//
//#[Route('/api')]
//class TestOrderController extends AbstractController
//{
//
//    public const REQUIRED_FIELDS = [
//        'amount'
//    ];
//
//    /**
//     * @var RequestCheckerService
//     */
//    private RequestCheckerService $requestCheckerService;
//
//    /**
//     * @var TestOrderService
//     */
//    private TestOrderService $testOrderService;
//
//    /**
//     * @var EntityManagerInterface
//     */
//    private EntityManagerInterface $entityManager;
//
//    /**
//     * @param RequestCheckerService $requestCheckerService
//     * @param TestOrderService $testOrderService
//     * @param EntityManagerInterface $entityManager
//     */
//    public function __construct(
//        RequestCheckerService  $requestCheckerService,
//        TestOrderService       $testOrderService,
//        EntityManagerInterface $entityManager
//    ) {
//        $this->requestCheckerService = $requestCheckerService;
//        $this->testOrderService = $testOrderService;
//        $this->entityManager = $entityManager;
//    }
//
//    /**
//     * @throws Exception
//     */
//    #[Route('/order', name: 'create_order', methods: [Request::METHOD_POST])]
//    #[IsGranted(User::ROLE_USER)]
//    public function createOrder(Request $request): JsonResponse
//    {
//        $requestData = json_decode($request->getContent(), true);
//
//        $this->requestCheckerService->check($requestData, self::REQUIRED_FIELDS);
//
//        /** @var User $user */
//        $user = $this->getUser();
//
//        $testOrder = $this->testOrderService->createTestOrderObject($requestData['amount'], $user);
//
//        $this->entityManager->flush();
//
//        return new JsonResponse($testOrder, Response::HTTP_CREATED);
//    }
//
//}
