<?php

namespace App\EventSubscriber;
      
use Twig\Environment;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionSubscriber implements EventSubscriberInterface
{
    /**
     * Undocumented variable
     *
     * @var \Twig\Environment
     */
    protected $twig;
    public function __construct(Environment $twig){
        $this->twig = $twig;
    }
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if($exception instanceof HttpException){
            $data = [
                'status' => $exception->getStatusCode(),
                'message' => $exception->getMessage()
            ];
        } else {

            $err = ["Oups", "T'es nul" , "Graillé l'tacos "];
            $data = [
                "status" => "500",
                "message" => $err[array_rand($err)]
            ];
        }

        $event->setResponse(new Response ($this->twig->render('error.html.twig', $data), $data["status"]));
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
