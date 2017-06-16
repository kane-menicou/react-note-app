<?php

namespace AppBundle\WebsocketAction;

use AppBundle\Entity\State;
use AppBundle\Model\WebsocketActionInterface;
use Doctrine\ORM\EntityManager;

class GetNoteDataAction implements WebsocketActionInterface
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
//        return [
//            'stateToSave' => ['notes' => [
//                [
//                    'state' => 0,
//                    'noteText' => '123',
//                    'stateIndex' => 1
//                ],
//                [
//                    'state' => 0,
//                    'noteText' => '1234',
//                    'stateIndex' => 2
//                ],
//                [
//                    'state' => 1,
//                    'noteText' => '23132',
//                    'stateIndex' => 2
//                ],
//                [
//                    'state' => 0,
//                    'noteText' => '123321',
//                    'stateIndex' => 3
//                ],
//                [
//                    'state' => 0,
//                    'noteText' => '123 extra long notes that is so long',
//                    'stateIndex' => 1
//                ],
//            ],
//                'states' => [
//                    [
//                        'icon' => 'fa fa-circle',
//                        'style' => [
//                            'textDecoration' => 'none'
//                        ]
//                    ],
//                    [
//                        'icon' => 'fa fa-exclamation',
//                        'style' => [
//                            'textDecoration' => 'underline'
//                        ]
//                    ],
//                    [
//                        'icon' => 'fa fa-building',
//                        'style' => [
//                            'textDecoration' => 'underline',
//                            'color' => 'red'
//                        ]
//                    ],
//                    [
//                        'icon' => 'fa fa-check',
//                        'style' => [
//                            'textDecoration' => 'line-through',
//                            'color' => 'grey'
//                        ]
//                    ],
//                ]
//            ]
//        ];

        $notes = $this->entityManager->getRepository(State::class)->findOneBy([
            'list' => $requestArray['list']
        ]);

        if ($notes === null) {
            $error = new ErrorAction('No list found');
            return $error->onActionRequest($requestArray);
        }

        return ['stateToSave' => $notes->getState()];
    }
}