<?php
declare(strict_types=1);

namespace App\Security;

use Psr\Container\ContainerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * Class UserProvider
 * @package App\Security
 */
class UserProvider implements UserProviderInterface
{
    private $container;

    /**
     * UserProvider constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Symfony calls this method if you use features like switch_user
     * or remember_me.
     *
     * If you're not using these features, you do not need to implement
     * this method.
     *
     * @return UserInterface
     * @param string $username
     * @throws UsernameNotFoundException if the user is not found
     * @throws \Exception
     */
    public function loadUserByUsername($username): UserInterface
    {
        try {
            $user = new User();
            $user
                ->setUsername($this->container->getParameter('user.name'))
                ->setApiToken($this->container->getParameter('user.api.token'))
                ->setRoles(['ROLE_API']);

            return $user;
        } catch (\Exception $exception) {
            throw new \Exception('Server failure');
        }
    }

    /**
     * Refreshes the user after being reloaded from the session.
     *
     * When a user is logged in, at the beginning of each request, the
     * User object is loaded from the session and then this method is
     * called. Your job is to make sure the user's data is still fresh by,
     * for example, re-querying for fresh User data.
     *
     * If your firewall is "stateless: true" (for a pure API), this
     * method is not called.
     *
     * @param UserInterface $user
     * @return UserInterface|null
     * @throws \Exception
     */
    public function refreshUser(UserInterface $user): ?UserInterface
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Invalid user class "%s".', get_class($user)));
        }
    }

    /**
     * Tells Symfony to use this provider for this User class.
     * @param string $class
     * @return bool
     */
    public function supportsClass($class): bool
    {
        return User::class === $class;
    }
}
