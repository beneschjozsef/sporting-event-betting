<?php

namespace App\Http\Middleware;

use Closure;
use App\Entities\User;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;

class Authenticate
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function handle(Request $request, Closure $next)
    {
        $token = $request->bearerToken();


        if (!$token) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['api_token' => $token]);

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // A hitelesített felhasználó hozzáadása a kéréshez
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}
