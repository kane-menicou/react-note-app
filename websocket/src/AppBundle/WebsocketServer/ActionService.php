<?php
//
namespace AppBundle\WebsocketServer;

use AppBundle\Model\WebsocketActionInterface;
use AppBundle\WebsocketAction\ErrorAction;
use Ratchet\AbstractConnectionDecorator;
use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;
use SplObjectStorage;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;

class ActionService implements MessageComponentInterface
{

    /**
     * @var SplObjectStorage
     */
    protected $clients;

    /**
     * @var array
     */
    protected $activeWebSocketUsers;

    /**
     * @var Container
     */
    private $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->clients = new SplObjectStorage();
        $this->container = $container;
    }

    /**
     * @param AbstractConnectionDecorator|ConnectionInterface $conn
     */
    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);

        echo 'connection from ' . $conn->resourceId . "\n";
    }

    /**
     * @param AbstractConnectionDecorator|ConnectionInterface $conn
     */
    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);

        echo 'disconnection from ' . $conn->resourceId . "\n";
    }

    /**
     * @param AbstractConnectionDecorator|ConnectionInterface $conn
     * @param  \Exception $e
     */
    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "an error has occurred: " . "\n";
        echo $e->getMessage() . "\n";
    }

    /**
     * @param AbstractConnectionDecorator|ConnectionInterface $from
     * @param  $msg
     *
     * @throws \Exception
     */
    public function onMessage(ConnectionInterface $from, $msg)
    {
        $message = (array) json_decode($msg, true);

        try {
            $actionClass = $this->container->get('app.websocket_actions.' . $message['action']);
        } catch (ServiceNotFoundException $e) {
            $actionClass = new ErrorAction('Sorry something went wrong');
        }

        if (! $actionClass instanceof WebsocketActionInterface) {
            $actionClass = new ErrorAction('Sorry something went wrong');
        }

        $from->send(json_encode($actionClass->onActionRequest($message)));
    }
}
