<?php
/**
 * Created by PhpStorm.
 * User: emrevural
 * Date: 15.05.17
 * Time: 19:06
 */

namespace Project\Utils\Core\Listeners;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {



        // You get the exception object from the received event
        $exception = $event->getException();

//        dump($exception);
//        dump($event);


        $message = sprintf($exception->getMessage(),
            $exception->getCode()
        );

        // Customize your response object to display the exception details
        $response = new Response();
        $response->setContent($message);

        // HttpExceptionInterface is a special type of exception that
        // holds status code and header details
        if ($exception instanceof HttpExceptionInterface) {

            $response->setStatusCode($exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());

            echo $message;

//            dump(strpos($message,"kjhgf"));
            exit;
            if(strpos($message,"No route found")){
                echo "var";
            }else{
                echo "yok";
            }
            exit;
            echo $message;
            exit;



        } else {



            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        // Send the modified response object to the event
//        $event->setResponse($response);
    }
}
