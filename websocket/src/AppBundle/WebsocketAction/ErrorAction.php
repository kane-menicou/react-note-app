<?php

namespace AppBundle\WebsocketAction;

use AppBundle\Model\WebsocketActionInterface;

class ErrorAction implements WebsocketActionInterface
{
    /**
     * @var string
     */
    private $error;

    public function __construct(string $error)
    {
        $this->error = $error;
    }

    /**
     * @param array $requestArray
     * @return array
     */
    public function onActionRequest(array $requestArray): array
    {
        return [
            'error' => $this->error
        ];
    }
}