<?php
namespace Flow2Lab\EventSourcing\Event;

use Flow2Lab\EventSourcing\Message;
use DateTimeZone;

abstract class DomainEvent implements Message
{

    const DATE_FORMAT = 'Y-m-d\TH:i:s.uP';

    /**
     * @var integer
     */
    public $version = 0;

    /**
     * @var string
     */
    public $occurredOn;

    public function __construct()
    {
        $occurredOn = \DateTime::createFromFormat(
            'U.u',
            sprintf('%.6f', microtime(true)),
            new DateTimeZone('UTC')
        );

        $this->occurredOn = $occurredOn->format(self::DATE_FORMAT);
    }

}