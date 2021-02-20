<?php

namespace App\Middleware;

use App\Api\Error;
use App\Exception\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionFormatter implements EventSubscriberInterface
{
    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => 'onException'];
    }

    public function onException(ExceptionEvent $event)
    {
        $throwable = $event->getThrowable();
        $code = JsonResponse::HTTP_INTERNAL_SERVER_ERROR;
        if ($throwable instanceof ValidationException) {
            $code = JsonResponse::HTTP_BAD_REQUEST;
            $details = $throwable->getDetails();
        } elseif ($throwable instanceof HttpException) {
            $code = $throwable->getStatusCode();
        } else {
            $details = $throwable->getTrace();
        }
        $event->setResponse(
            new JsonResponse(
                new Error(
                    $throwable->getCode(),
                    $throwable->getMessage(),
                    $details ?? []
                ),
                $code
            )
        );
    }
}