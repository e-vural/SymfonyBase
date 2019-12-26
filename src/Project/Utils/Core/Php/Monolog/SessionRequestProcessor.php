<?php
/**
 * Created by PhpStorm.
 * User: bugrayuksel
 * Date: 05/11/15
 * Time: 18:37
 */

namespace Project\Utils\Core\Php\Monolog;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Project\UserBundle\Entity\User;

class SessionRequestProcessor
{
    private $session;
    private $token;
    private $tokenStorage;
    private $requestStack;

    public function __construct(Session $session, TokenStorageInterface $tokenStorage, RequestStack $requestStack)
    {
        $this->session = $session;
        $this->tokenStorage = $tokenStorage;
        $this->requestStack = $requestStack;
    }

    public function processRecord(array $record)
    {
        if (null === $this->token) {
            try {
                $this->token = substr($this->session->getId(), 0, 8);
            } catch (\RuntimeException $e) {
                $this->token = '????????';
            }
            $this->token .= '-' . substr(uniqid(), -8);
        }

        if ($this->tokenStorage->getToken()) {
            $user = $this->tokenStorage->getToken()->getUser();

            if ($user instanceof User) {

                $record['extra']['kullanici'] = [
                    'id' => $user->getId(),
                    'username' => $user->getUsername(),
                    'email' => $user->getEmail(),
                    'roles' => $user->getRoles()
                ];

            }
        }

        $request = $this->requestStack->getCurrentRequest();

        if ($request) {
            // $record['extra']['host'] = $request->getHost();
            // $record['extra']['uri'] = $request->getRequestUri();
            $record['extra']['url'] = $request->getUri();
            $record['extra']['querystring'] = $request->getQueryString();
        }

        $record['extra']['token'] = $this->token;

        return $record;
    }

}
