<?php

namespace AppBundle\WebsocketAction;

use AppBundle\Entity\State;
use AppBundle\Model\WebsocketActionInterface;
use Doctrine\ORM\EntityManager;

class UpdateStateAction implements WebsocketActionInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $requestArray
     * @return array
     */
    public function onActionRequest(array $requestArray): array
    {
        $state = $this->entityManager->getRepository(State::class)->findAll()[0];
        $state->setState($requestArray['state']);

        $this->entityManager->persist($state);
        $this->entityManager->flush($state);

        return ['message' => 'Updated'];
    }
}