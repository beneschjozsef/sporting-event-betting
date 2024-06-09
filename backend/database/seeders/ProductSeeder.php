<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Entities\Product;
use Doctrine\ORM\EntityManagerInterface;

class ProductSeeder extends Seeder
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function run()
    {
        $product1 = new Product();
        $product1->setName('Product 1');
        $product1->setPrice(10.99);

        $this->entityManager->persist($product1); // Entitás persistálása
        $this->entityManager->flush(); // Entitások mentése az adatbázisba

        $product2 = new Product();
        $product2->setName('Product 2');
        $product2->setPrice(20.99);

        $this->entityManager->persist($product2); // Entitás persistálása
        $this->entityManager->flush(); // Entitások mentése az adatbázisba

        // További entitások hozzáadása szükség esetén
    }
}
