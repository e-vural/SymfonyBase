<?php


namespace Project\Utils\Core\Listeners;



use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\SecurityEvents;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

class LoginListener
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * Do the magic.
     *
     * @param InteractiveLoginEvent $event
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {




//        if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
//            // user has just logged in
//        }
//
//        if ($this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
//            // user has logged in using remember_me cookie
//        }
//
//        // do some other magic here
//        $user = $event->getAuthenticationToken()->getUser();

        // ...
    }




}
