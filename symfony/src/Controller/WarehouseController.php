<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/warehouse', name: 'api_warehouse_')]
class WarehouseController extends AbstractController
{

    private array $products = [
        ['id' => 1, 'title' => 'Laptop ASUS', 'sku' => 'WH-LAP-01', 'quantity' => 15, 'price' => 1200.00],
        ['id' => 2, 'title' => 'Wireless Mouse', 'sku' => 'WH-MOU-05', 'quantity' => 120, 'price' => 25.50],
        ['id' => 3, 'title' => 'Mechanical Keyboard', 'sku' => 'WH-KEY-12', 'quantity' => 45, 'price' => 85.00]
    ];


    #[Route('/products', name: 'index', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return $this->json($this->products, 200);
    }

    #[Route('/products', name: 'store', methods: ['POST'])]
    public function store(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (empty($data['title']) || empty($data['sku'])) {
            return $this->json(['error' => 'Missing required fields (title or sku)'], 400);
        }

        $newProduct = [
            'id' => count($this->products) + 1,
            'title' => $data['title'],
            'sku' => $data['sku'],
            'quantity' => $data['quantity'] ?? 0,
            'price' => $data['price'] ?? 0.0
        ];

        return $this->json([
            'message' => 'Product successfully added to Symfony Warehouse',
            'product' => $newProduct
        ], 201);
    }

    #[Route('/products/{id}', name: 'update', methods: ['PATCH'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        return $this->json([
            'message' => "Product ID $id updated successfully in Symfony Warehouse",
            'updated_fields' => $data
        ], 200);
    }

    #[Route('/products/{id}', name: 'destroy', methods: ['DELETE'])]
    public function destroy(int $id): JsonResponse
    {
        return $this->json([
            'message' => "Product ID $id has been successfully removed from Symfony Warehouse"
        ], 200);
    }
}
