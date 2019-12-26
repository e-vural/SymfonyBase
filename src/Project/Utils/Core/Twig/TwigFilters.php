<?php
/**
 * Created by PhpStorm.
 * User: emrevural
 * Date: 2018-12-17
 * Time: 13:40
 */

namespace Project\Utils\Core\Twig;


use Project\Utils\Core\Php\Tools;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig\TwigFilter;

class TwigFilters extends \Twig_Extension
{

    private $container;
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

    }

    public function getFilters()
    {
        return array(
            // the logic of this filter is now implemented in a different class
//            new TwigFilter('array_column', array(new ArrayTwig(), 'array_column')),
            new TwigFilter('str_replace', array($this, 'str_replace')),
            new TwigFilter('dateLocale', array($this, 'dateLocale')),
            new TwigFilter('numberFormatter', array($this, 'numberFormatter')),

        );
    }

    public function str_replace($string, $search, $replace)
    {
        return str_replace($search, $replace, $string);
    }

    public function numberFormatter($value = null)
    {
        $tools = $this->container->get(Tools::class);
        if(!$value){
            $value = 0;
        }

        return $tools->numberFormatter($value);
    }

    public function dateLocale($date,$pattern = null)
    {

        $tools = $this->container->get(Tools::class);
        return $tools->dateLocaleParser($date);
    }

}
