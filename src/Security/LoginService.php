<?php
declare(strict_types=1);

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoginService
 * @package App\Security
 */
class LoginService
{
    private $container;
    private $userName;
    private $userPassword;
    private $apiToken;

    /**
     * LoginService constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->userName = $this->container->getParameter('user.name');
        $this->userPassword = $this->container->getParameter('user.password');
        $this->apiToken = $this->container->getParameter('user.api.token');
    }

    /**
     * @param Request $request
     * @return array
     */
    public function authorizeUser(Request $request): ?string
    {
        $message = null;
        if (
            $request->request->get('username') === $this->userName &&
            $request->request->get('password') === $this->userPassword
        ) {

            $pubkey = $this->container->getParameter('my_public_keyset');

            $message = [
                'message' => 'Login successful',
                'tokenKey' => 'X-AUTH-TOKEN',
                'tokenValue' => $pubkey
            ];
        }

        return $message;
    }
}

