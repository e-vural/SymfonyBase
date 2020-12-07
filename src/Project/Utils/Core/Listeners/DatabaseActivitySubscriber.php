<?php


namespace Project\Utils\Core\Listeners;



use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DatabaseActivitySubscriber implements EventSubscriber
{

    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    // this method can only return the event names; you cannot define a
    // custom method name to execute when each event triggers
    public function getSubscribedEvents()
    {
        return [
            Events::postPersist,
            Events::postRemove,
            Events::postUpdate,
        ];
    }

    // callback methods must be called exactly like the events they listen to;
    // they receive an argument of type LifecycleEventArgs, which gives you access
    // to both the entity object of the event and the entity manager itself
    public function postPersist(LifecycleEventArgs $args)
    {

        $this->logActivity('add', $args);
    }

    public function postRemove(LifecycleEventArgs $args)
    {
        $this->logActivity('delete', $args);
    }

    public function postUpdate(LifecycleEventArgs $args)
    {
        $this->logActivity('update', $args);
    }

    private function logActivity(string $action, LifecycleEventArgs $args)
    {


        // ... get the entity information and log it somehow
    }


}
