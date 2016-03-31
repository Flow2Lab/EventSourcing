<?php
namespace Flow2Lab\EventSourcing\Command\Bus;

use Flow2Lab\EventSourcing\Command\Command;

interface CommandBusInterface
{

    /**
     * @param Command $command
     * @return void
     */
    public function handle(Command $command);

}