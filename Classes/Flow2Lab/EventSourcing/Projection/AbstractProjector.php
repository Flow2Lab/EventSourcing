<?php
namespace Flow2Lab\EventSourcing\Projection;

use Flow2Lab\EventSourcing\Event\Handler\AbstractEventHandler;
use Flow2Lab\EventSourcing\Projection\Hydration\ArrayHydrator;
use Flow2Lab\EventSourcing\Projection\Hydration\DtoHydrator;
use Flow2Lab\EventSourcing\Projection\Hydration\HydratorInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\Connection;
use TYPO3\Flow\Annotations as Flow;

/**
 * @Flow\Scope("singleton")
 */
abstract class AbstractProjector extends AbstractEventHandler implements ProjectorInterface
{

    /**
     * @var string
     */
    protected $projectionClassName;

    /**
     * @var HydratorInterface
     */
    protected $hydrator;

    public function __construct()
    {
        $this->initializeHydrator();
    }

    protected function initializeHydrator()
    {
        if ($this->projectionClassName !== NULL) {
            $this->hydrator = new DtoHydrator($this->projectionClassName);
        } else {
            $this->hydrator = new ArrayHydrator();
        }
    }

    public function getProjectionClassName()
    {
        return $this->projectionClassName;
    }

    /**
     * @param array $result
     * @return array
     */
    protected function hydrateResult(array $result)
    {
        $hydrator = $this->hydrator;

        return array_map(function ($row) use ($hydrator) {
            return $hydrator->hydrate($row);
        }, $result);
    }

}