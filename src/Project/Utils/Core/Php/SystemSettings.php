<?php
/**
 * Created by PhpStorm.
 * User: emrevural
 * Date: 2018-12-17
 * Time: 12:10
 */

namespace Project\Utils\Core\Php;


use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;

class SystemSettings
{

    protected $container;
    public function __construct(ContainerInterface $container)
    {

        $this->container = $container;

    }

    /***
     * YAZILIMI GELİŞTİREN ARKADAŞ GLOBAL OLRAK NEYE İHTİYACI VARSA BURADAN ÇEKECEK. BURAYA EKELYECEK
     * ÖRNEK OLARAK GİRİŞ YAPAN FİRMA getLoggedFirm() gibi
     *
     */


    /**
     * Giriş yapan kullanıcıları buradan çekeceğiz.
     */
    public function getLoggedUser(){

        return;
    }

    /**
     * Giriş yapan firma buradan çekeceğiz.
     */
    public function getLoggedFirm(){

        return;
    }



    public function getBaseUrl()
    {
        $request = $this->container->get("request_stack")->getCurrentRequest();

        // $request->getBasePath()
        return $request->getScheme() . '://' . $request->getHttpHost();

    }


    public function getUuid()
    {

        //TODO ramsey uuid bundle kurulacak
        $uuid1 = Uuid::uuid1();
        return $uuid1->toString(); // i.e. e4eaaaf2-d142-11e1-b3e4-080027620cdd

    }

}
