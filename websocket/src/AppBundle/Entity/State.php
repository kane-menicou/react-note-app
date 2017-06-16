<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
* @ORM\Entity
* @ORM\Table()
*/
class State
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var array
     *
     * @ORM\Column(type="array")
     */
    private $state;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $list;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getState(): array
    {
        return $this->state;
    }

    /**
     * @param array $state
     */
    public function setState(array $state)
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getList(): string
    {
        return $this->list;
    }

    /**
     * @param string $list
     */
    public function setList(string $list)
    {
        $this->list = $list;
    }
}