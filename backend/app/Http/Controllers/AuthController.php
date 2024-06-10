<?php

namespace App\Http\Controllers;

use App\Entities\User;
use Doctrine\ORM\EntityManagerInterface;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    protected $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|email|unique:App\Entities\User',
            'password' => 'required|string|min:6',
        ]);

        $user = new User();
        $user->setName($request->input('name'));
        $user->setEmail($request->input('email'));
        $user->setPassword(password_hash($request->input('password'), PASSWORD_BCRYPT));

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $request->input('email')]);

        if (!$user || !password_verify($request->input('password'), $user->getPassword())) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = bin2hex(random_bytes(32));
        $user->setApiToken($token);
        $this->entityManager->flush();

        return response()->json(['token' => $token]);
    }

    public function logout(Request $request)
    {
        $user = $request->user();
        if ($user) {
            $user->setApiToken(null);
            $this->entityManager->flush();
            return response()->json(['message' => 'Logged out successfully']);
        }

        return response()->json(['message' => 'User not authenticated'], 401);
    }
}
