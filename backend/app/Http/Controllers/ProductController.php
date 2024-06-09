<?php

namespace App\Http\Controllers;

use App\Entities\Product;
use Illuminate\Http\Request;
use Doctrine\ORM\EntityManagerInterface;

class ProductController extends Controller
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function index()
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();
        $productData = [];
        foreach ($products as $product) {
            $productData[] = [
                'id' => $product->getId(),
                'name' => $product->getName(),
                'price'  => $product->getPrice()
            ];
        }
        return response()->json($productData);
    }
}
