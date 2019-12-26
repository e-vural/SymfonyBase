<?php
/**
 * Created by PhpStorm.
 * User: emrevural
 * Date: 2019-12-17
 * Time: 21:31
 */

namespace Project\AdminBundle\Helpers\User;


use Project\AdminBundle\Entity\Profile;
use Project\AdminBundle\Entity\User;
use Project\AdminBundle\Helpers\HelperTrait;
use Project\AdminBundle\Helpers\HelperInterface;
use Symfony\Bundle\FrameworkBundle\Controller\ControllerTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\FormInterface;

class UserHelper implements HelperInterface
{

    use HelperTrait;


    public function getFormType(){

        return 'Project\AdminBundle\Form\User\UserType';
    }

    public function getEntity(){

        return 'Project\AdminBundle\Entity\User';
    }







}
