<?php
namespace Flow2Lab\EventSourcing\Event\Handler;

use Flow2Lab\EventSourcing\Event\DomainEvent;
use Flow2Lab\EventSourcing\Event\Handler\Exception\UnableToHandleEventException;

abstract class AbstractEventHandler implements EventHandlerInterface
{

    /**
     * @var string[]
     */
    protected $subscribedToEvents = [];

    /**
     * @param DomainEvent $event
     * @return boolean
     */
    public function canHandleEvent(DomainEvent $event)
    {
        return in_array(get_class($event), $this->subscribedToEvents);
    }

    /**
     * @param DomainEvent $event
     * @throws UnableToHandleEventException
     */
    public function handle(DomainEvent $event)
    {
        $handleMethod = $this->getHandleMethodForEvent($event);

        if (method_exists($this, $handleMethod) === FALSE) {
            throw new UnableToHandleEventException('The event "' . get_class($event) . '" could not be handled by the event handler "' . get_class($this) . '".', 1427365186);
        }

        $this->$handleMethod($event);
    }

    /**
     * @param DomainEvent $event
     * @return string
     */
    protected function getHandleMethodForEvent(DomainEvent $event)
    {
        $eventName = $this->getEventName($event);
        return 'handle' . $eventName . 'Event';
    }

    /**
     * @param DomainEvent $event
     * @return string
     */
    protected function getEventName(DomainEvent $event)
    {
        $classNameParts = explode('\\', get_class($event));
        return array_pop($classNameParts);
    }

}