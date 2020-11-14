<?php

namespace AppBundle\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Exception\ApiErrorHandlerCatchableInterface;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;

class ApiExceptionSubscriber implements EventSubscriberInterface
{
    /**
     *
     * @TODO add logger for response which should stay private
     *
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $e = $event->getException();

        if (! ($e instanceof ApiErrorHandlerCatchableInterface || $e instanceof UniqueConstraintViolationException)) {
            return;
        }

        $errorCode = $e->getCode() ? $e->getCode() : Response::HTTP_BAD_REQUEST;

        $response = new Response(
            $e->getMessage(),
            $errorCode
        );
        $response->headers->set('Content-Type', 'application/problem+json');

        $event->setResponse($response);
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::EXCEPTION => 'onKernelException'
        );
    }
}
