<?php
namespace Flow2Lab\EventSourcing;

interface AggregateRootInterface
{

    /**
     * @param array $stream
     * @return AggregateRootInterface
     */
    static public function loadFromEventStream(array $stream = []);

    /**
     * @return string Global identifier of the aggregate
     */
    public function getIdentifier();

    /**
     * @return array<DomainEvent>
     */
    public function getUncommittedChanges();

    /**
     * Empties the uncommitted changes
     *
     * @return void
     */
    public function markChangesAsCommitted();

}