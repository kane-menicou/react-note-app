<?php

namespace AppBundle\Model;

interface WebsocketActionInterface
{
    /**
     * @param array $requestArray
     * @return array
     */
    public function onActionRequest(array $requestArray) : array;
}