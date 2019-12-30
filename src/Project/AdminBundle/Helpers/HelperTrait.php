<?php
/**
 * Created by PhpStorm.
 * User: emrevural
 * Date: 2019-12-18
 * Time: 15:26
 */

namespace Project\AdminBundle\Helpers;


use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormInterface;

trait HelperTrait
{

    use ControllerTrait;

    /** @var bool  */
    public $isFlush = true;

    public $container;

    /** @var FormInterface $form */
    private $form;

    /** @var bool  */
    private $dataSaved = false;


    /**
     * @return EntityManager
     */
    public function getEntityManager(){

        return $this->getDoctrine()->getManager();
    }

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }


    /**
     * @param null $entity
     * @return array
     */
    public function generateForm($entity = null)
    {

        $className = $this->getEntity();

        if (!$entity) {
            $entity = new $className();
        }

        $request = $this->container->get("request_stack")->getCurrentRequest();
        $formType = $this->getFormType();
        /** @var FormInterface $form */
        $form = $this->createForm($formType, $entity);

        $form->handleRequest($request);
        $this->form = $form;
        if ($form->isSubmitted() && $form->isValid()) {
            $this->dataSaved = $this->setData();
        }

        $response = array("form" => $form,"entity" => $entity);
        return $response;
    }

    public function setData()
    {
        $entity = $this->form->getData();
        $em = $this->getEntityManager();
        $em->persist($entity);

        if($this->isFlush){
            $em->flush();
        }

        return true;
    }

    /**
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }


    /**
     * @return bool
     */
    public function isDataSaved()
    {
        return $this->dataSaved;
    }


//    public function beforeFlush(){
//
//    }




    public function getFormHtml(){

        //TODO her helper içinde formun html olarak çıktısı için
    }

}
