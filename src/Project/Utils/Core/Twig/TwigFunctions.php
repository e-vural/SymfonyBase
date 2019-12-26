<?php
/**
 * Created by PhpStorm.
 * User: emrevural
 * Date: 2018-12-17
 * Time: 13:40
 */

namespace Project\Utils\Core\Twig;


use Project\Utils\Core\Php\SystemSettings;
use Symfony\Component\DependencyInjection\ContainerInterface;

class TwigFunctions extends \Twig_Extension
{

    private $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('getParameters', array($this, 'getParameters')),
//            new \Twig_SimpleFunction('getStaffDetail', array($this, 'getStaffDetail')),
        );
    }


    public function getParameters($key){

        return $this->container->getParameter($key);
    }


}
