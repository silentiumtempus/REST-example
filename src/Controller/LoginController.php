<?php
declare(strict_types=1);

namespace App\Controller;

use App\Security\LoginService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class LoginController
 * @package App\Controller
 */
class LoginController
{
    /**
     * @param Request $request
     * @param LoginService $loginService
     * @return JsonResponse
     * @Route("/login", name = "login")
     */

    public function login(
        Request $request,
        LoginService $loginService
    ): JsonResponse
    {
        return new JsonResponse($loginService->authorizeUser($request));
    }

}