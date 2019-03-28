<?php
declare(strict_types=1);

namespace App\Event\Listener;

use Exception;
use Psr\Log\LoggerInterface;
use App\Exception\ApplicationException;
use App\DataTransformer\ResponseTransformer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;

/**
 * Class ExceptionListener
 * @package App\Event\Listener
 */
class ExceptionListener
{
    private $logger;

    /**
     * ExceptionListener constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @param GetResponseForExceptionEvent $event
     */
    public function onKernelException(GetResponseForExceptionEvent $event): void
    {
        if ($event->getException() instanceof ApplicationException )
        {
            $response = $this->handleKnownExceptions($event->getException());
        } else {
            $response = $this->handleUnknownExceptions($event->getException());
        }

        $event->setResponse($response);
    }

    /**
     * @param Exception $exception
     * @return Response
     */
    private function handleKnownExceptions(Exception $exception): Response
    {
        $header = [];
        if (Response::HTTP_BAD_REQUEST === $exception->getStatusCode()) {
            $header = ['Content-Type' => ResponseTransformer::CONTENT_TYPE];
        } else {
            $this->logger->error($exception);
        }

        return new Response($exception->getMessage(), $exception->getStatusCode(), $header);
    }

    /**
     * @param Exception $exception
     * @return Response
     */
    private function handleUnknownExceptions(Exception $exception): Response
    {
        $this->logger->error($exception);

        return new Response('An unknown exception occurred.', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
