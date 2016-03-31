<?php
namespace Flow2Lab\EventSourcing\Event\Handler;

use Flow2Lab\EventSourcing\Event\DomainEvent;

interface EventHandlerInterface
{

    /**
     * @param DomainEvent $event
     * @return boolean
     */
    public function canHandleEvent(DomainEvent $event);

    /**
     * @param DomainEvent $event
     * @return void
     */
    public function handle(DomainEvent $event);

}