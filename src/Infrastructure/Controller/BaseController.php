<?php

namespace App\Infrastructure\Controller;

use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;

abstract class BaseController extends AbstractFOSRestController
{
    use HandleTrait;

    /**
     * BaseController constructor.
     * @param MessageBusInterface $messageBus
     */
    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    /**
     * @param $message
     * @return mixed
     */
    protected function handleMessage($message)
    {
        return $this->handle($message);
    }
}
