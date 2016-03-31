<?php
namespace Flow2Lab\EventSourcing\Tests\Unit;

use Flow2Lab\EventSourcing\AggregateRootInterface;
use Flow2Lab\EventSourcing\Command\Command;
use Flow2Lab\EventSourcing\Command\Handler\CommandHandler;
use Flow2Lab\EventSourcing\Event\DomainEvent;
use TYPO3\Flow\Tests\UnitTestCase;

abstract class AggregateTest extends UnitTestCase
{

    /**
     * @var string Class name of the aggregate
     */
    public $subjectType;

    /**
     * @var AggregateRootInterface
     */
    public $subject;

    /**
     * @var DomainEvent[]
     */
    public $producedEvents = [];

    /**
     * @var \Exception
     */
    public $caughtException;

    /**
     * @return DomainEvent[]
     */
    abstract public function given();

    /**
     * @return Command
     */
    abstract public function when();

    /**
     * @return CommandHandler
     */
    abstract public function onHandler();

    public function setUp()
    {
        try {
            /** @var AggregateRootInterface $subject */
            $subjectType = $this->subjectType;
            $events = $this->given();

            // only load the subject when events are given
            if (count($events) > 0) {
                $this->subject = $subjectType::loadFromEventStream($events);
            }

            $this->onHandler()->handle($this->when());
            $this->producedEvents = $this->subject->getUncommittedChanges();
        } catch (\Exception $e) {
            $this->caughtException = $e;
        }
    }

}