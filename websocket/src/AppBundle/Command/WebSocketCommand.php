<?php

namespace AppBundle\Command;

use AppBundle\WebsocketServer\ActionService;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WebSocketCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('app:websocket')
            ->setDescription('Starts websocket server.')
            ->setHelp('This command allows you to start the websocket server.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new ActionService($this->getContainer())
                )
            ),
            8081,
            '127.0.0.1'
        );

        $server->run();
    }
}