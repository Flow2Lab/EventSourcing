<?php
namespace Flow2Lab\EventSourcing\Store\Backend\Translator;

use Flow2Lab\EventSourcing\Event\DomainEvent;
use Flow2Lab\EventSourcing\Serializer\ArraySerializer;
use Flow2Lab\EventSourcing\Store\Backend\Exception\IncompatibleModelException;
use EventStore\StreamFeed\Event;
use EventStore\WritableEvent;
use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
class WritableEventTranslator
{

    /**
     * @var ArraySerializer
     * @Flow\Inject
     */
    protected $arraySerializer;

    /**
     * @param DomainEvent $event
     * @return WritableEvent
     */
    public function toWritableEvent(DomainEvent $event)
    {
        $serializedEvent = $this->arraySerializer->serialize($event);

        $eventType = $serializedEvent['messageType'];
        $data = $serializedEvent['payload'];

        unset($data['aggregateId']);
        unset($data['version']);

        return WritableEvent::newInstance($eventType, $data);
    }

    /**
     * @param Event $event
     * @param string $eventType
     * @return DomainEvent
     * @throws IncompatibleModelException
     */
    public function fromEvent(Event $event, $eventType)
    {
        $data = $event->getData();

        return $this->arraySerializer->unserialize([
            'messageType' => $eventType,
            'payload' => $data
        ]);
    }

}