<?php

namespace App\Services;

use App\Entities\User;
use Doctrine\ORM\EntityManagerInterface;

class TokenService
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getUserByToken($token)
    {
        if (!$token) {
            return false;
        }
        return $this->entityManager->getRepository(User::class)->findOneBy(['api_token' => $token]);
    }
}
