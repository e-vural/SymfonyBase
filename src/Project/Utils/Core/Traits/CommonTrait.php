<?php
/**
 * Created by PhpStorm.
 * User: emrevural
 * Date: 2018-12-17
 * Time: 12:11
 */

namespace Project\Utils\Core\Traits;


use Project\Utils\Core\Php\GetConstant;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\Session;

trait CommonTrait
{
//
//    /***
//     * @var ContainerInterface
//     */
//    private $container;//
//
    /***
     * @var GetConstant
     */
    private $contants;

    /***
     * @var Session
     */
    private $session;



//TODO ÖNEMLİ. BURADA CONTAİNER OLMADAN HERYERDE KULLANILABİLECEK ŞEKİLDE FONKSİYOLAR OLMALI. REPOSİTORY İİÇNDE ÇALIŞMALI
    public function getLoggedUser(){

        return null;
    }

    public function getLoggedFirm(){

    }

    public function getBaseUrl(){

    }

    public function getUuid(){

    }

    private function getConstant(){

        $this->contants = new GetConstant();

    }

    private function addFlashMessage($type,$message){
        if(!$this->session){
            $this->session = new Session();
        }
        $this->session->getFlashBag()->add($type, $message);
    }

    private function addSuccessFlash($message){

        $this->addFlashMessage($this->contants->getConstant("flash_success_alias"),$message);
    }

    private function addInfoFlash($message){
        $this->addFlashMessage($this->contants->getConstant("flash_info_alias"),$message);
    }

    private function addWarningFlash($message){
        $this->addFlashMessage($this->contants->getConstant("flash_warning_alias"),$message);
    }

    private function addErrorFlash($message){
        $this->addFlashMessage($this->contants->getConstant("flash_error_alias"),$message);
    }

    private function addCustomFlash($type,$message){
        $this->addFlashMessage($type,$message);
    }

    private function prepareJsonResponse($dataArray,$message = null,$redirectUrl = null,$messageType = null){

        return  array(
            "data" => $dataArray,
            "msg" => $message,
            "redirect" => $redirectUrl,
            "messageType" => $messageType
        );

    }

    private function isAjax(){
        if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            /* special ajax here */
            return true;
        }
        return false;

    }

    private function returnError($options = array("mesaj" => "","data" => [],"redirectUrl" => null)){

        $redirectUrl = $options["redirectUrl"];

        if(!$redirectUrl){
            $redirectUrl = $_SERVER["HTTP_REFERER"];
        }
        if($this->isAjax()){
            $arr = $this->prepareJsonResponse($options["data"],$options["mesaj"]);
            $response = new JsonResponse($arr,405);

        }else{

            $response = new RedirectResponse($redirectUrl);
        }

        $response->send();
        exit;

    }

}
