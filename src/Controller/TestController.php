<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/menu')]
class TestController extends AbstractController
{
    private $menus = [
        ['id' => 1, 'name' => 'Breakfast', 'items' => ['Eggs', 'Toast']],
        ['id' => 2, 'name' => 'Lunch', 'items' => ['Soup', 'Salad']],
        ['id' => 3, 'name' => 'Dinner', 'items' => ['Chicken', 'Rice']],
    ];

    #[Route('', name: 'app_collection_menu', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function getCollection(): JsonResponse
    {
        return new JsonResponse([
            'data' => $this->menus
        ], Response::HTTP_OK);
    }

    #[Route('/{id}', name: 'app_item_menu', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function getItem(int $id): JsonResponse
    {
        $menu = $this->findMenuById($id);
        return new JsonResponse([
            'data' => $menu
        ], Response::HTTP_OK);
    }

    #[Route('', name: 'app_create_menu', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function createItem(Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        if (!isset($data['name'])) {
            throw new UnprocessableEntityHttpException("Name is required");
        }
        $newMenu = [
            'id' => count($this->menus) + 1,
            'name' => $data['name'],
            'items' => $data['items'] ?? [],
        ];

        $this->menus[] = $newMenu;

        return new JsonResponse([
            'data' => $newMenu
        ], Response::HTTP_CREATED);
    }

    #[Route('/{id}', name: 'app_delete_menu', methods: ['DELETE'])]
    #[IsGranted('ROLE_ADMIN')]
    public function deleteItem(int $id): JsonResponse
    {

        $menu = $this->findMenuById($id);

        $this->menus = array_filter($this->menus, fn($m) => $m['id'] !== $id);
        $this->menus = array_values($this->menus);

        return new JsonResponse([], Response::HTTP_NO_CONTENT);
    }

    #[Route('/{id}', name: 'app_update_menu', methods: ['PATCH'])]
    #[IsGranted('ROLE_ADMIN')]
    public function updateItem(int $id, Request $request): JsonResponse
    {

        $data = json_decode($request->getContent(), true);

        if (!isset($data['name']) && !isset($data['items'])) {
            throw new UnprocessableEntityHttpException("At least one field (name or items) is required");
        }

        $menu = $this->findMenuById($id);

        $menu['name'] = $data['name'] ?? $menu['name'];

        return new JsonResponse([
            'data' => $menu
        ], Response::HTTP_OK);
    }



    private function findMenuById(int $id): array
    {
        foreach ($this->menus as $menu) {
            if ($menu['id'] === $id) {
                return $menu;
            }
        }

        throw new NotFoundHttpException("Menu with id $id not found");
    }
}