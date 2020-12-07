<?php


namespace Project\Utils\Core\Listeners;




use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Logout\LogoutHandlerInterface;


class LogoutListener implements LogoutHandlerInterface {
    protected $container;

    public function __construct(ContainerInterface $container){
        $this->container = $container;
    }

    public function logout(Request $Request, Response $Response, TokenInterface $Token) {

        // ..
        // Here goes the logic that you want to execute when the user logouts
        // ..

        // The following example will create the logout.txt file in the /web directory of your project
//        $myfile = fopen("logout.txt", "w");
//        fwrite($myfile, 'logout succesfully executed !');
//        fclose($myfile);
    }
}
