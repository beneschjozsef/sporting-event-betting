<?php

namespace App\Http\Middleware;

use Closure;
use App\Entities\User;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use App\Services\TokenService;

class Authenticate
{
    protected $entityManager;
    protected $tokenService;

    public function __construct(EntityManagerInterface $entityManager, TokenService $tokenService)
    {
        $this->entityManager = $entityManager;
        $this->tokenService = $tokenService;
    }

    public function handle(Request $request, Closure $next)
    {
        $user = $this->tokenService->getUserByToken($request->bearerToken());

        if (!$user) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        return $next($request);
    }
}
