<?php

namespace App\Controller;

use Exception;
use App\Repository\UserRepository;
use App\Service\AuthManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class AuthController extends AbstractController
{
    public function __construct(private readonly AuthManager $authManager)
    {
    }
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(
        Request                     $request,
        UserRepository              $userRepository,
        UserPasswordHasherInterface $passwordHasher
    ): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        try {
            $token = $this->authManager->login($data['email'], $data['password']);
            return new JsonResponse(['token' => $token]);
        } catch (AuthenticationException $e) {
            return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_UNAUTHORIZED);
        }
    }

    #[Route('/api/registration', name: 'api_registration', methods: ['POST', 'GET'])]
    public function registration(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        try {
            $user = $this->authManager->registration($data);
            return new JsonResponse(['message' => 'User registered successfully'], Response::HTTP_OK);
        } catch (Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
