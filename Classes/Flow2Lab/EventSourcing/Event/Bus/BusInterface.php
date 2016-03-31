<?php
namespace Flow2Lab\EventSourcing\Event\Bus;

use Flow2Lab\EventSourcing\Event\DomainEvent;

interface BusInterface
{

    /**
     * @param DomainEvent $event
     * @return void
     */
    public function publish(DomainEvent $event);

}