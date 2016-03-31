<?php
namespace Flow2Lab\EventSourcing\Store\Backend;

use Flow2Lab\EventSourcing\Event\DomainEvent;
use Flow2Lab\EventSourcing\Store\Backend\Exception\EventStreamNotFoundException;
use Flow2Lab\EventSourcing\Store\Backend\Exception\OptimisticLockException;

interface StoreBackendInterface
{

    /**
     * @param string $identifier
     * @param DomainEvent[] $events
     * @return void
     * @throws OptimisticLockException
     */
    public function append($identifier, array $events);

    /**
     * @param string $identifier
     * @return DomainEvent[]
     * @throws EventStreamNotFoundException
     */
    public function load($identifier);

}