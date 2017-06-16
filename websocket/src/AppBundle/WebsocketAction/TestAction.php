<?php

namespace AppBundle\WebsocketAction;

use AppBundle\Model\WebsocketActionInterface;

class TestAction implements WebsocketActionInterface
{

    /**
     * @param array $requestArray
     * @return array
     */
    public function onActionRequest(array $requestArray): array
    {
        return [
            'testData' => 'test data'
        ];
    }
}