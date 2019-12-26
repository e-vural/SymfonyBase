<?php
/**
 * Created by PhpStorm.
 * User: emrevural
 * Date: 2019-05-09
 * Time: 09:21
 */

namespace Project\Utils\Core\Php;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\Yaml\Yaml;

class GetConstant
{

    public function __construct()
    {

    }


    public function getConstant($name){

        /**
         * @var Container $container
         */
        $container = null;

        if($container){
            $container->getParameter($name);
        }

        $value = Yaml::parseFile('../app/config/constants.yml');
        $constantsParameters = $value["parameters"];
        return $constantsParameters[$name];

    }


}
