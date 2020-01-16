<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class ApiCsrfValidationSubscriber.
 */
class ApiCsrfValidationSubscriber implements EventSubscriberInterface
{
    /**
     * @param RequestEvent $event
     */
    public function onKernelRequest(RequestEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        if ($request->isMethodSafe(false)) {
            return;
        }

        if (!$request->attributes->get('_is_api')) {
            return;
        }

        if ($request->headers->get('Content-Type') != 'application/json') {
            $response = new JsonResponse([
                'message' => 'Invalid Content-Type'
            ], 415);

            $event->setResponse($response);

            return;
        }
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'kernel.request' => 'onKernelRequest',
        ];
    }
}
