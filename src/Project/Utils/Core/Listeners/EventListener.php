<?php

/**
 * Created by PhpStorm.
 * User: emrevural
 * Date: 15.05.17
 * Time: 18:55
 */

namespace Project\Utils\Core\Listeners;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class EventListener
{

    protected $service_container;
    protected $em;


    public function __construct(ContainerInterface $service_container)
    {
        $this->container = $service_container;

        $this->em = $this->container->get('doctrine')->getManager();

    }

    public function onKernelController(FilterControllerEvent $event)
    {


        $m = $this->container->getParameter("maintenance");

        if($m){
            echo "SİSTEMTE BAKIM VARDIR";
            exit;
        }


    }

}
