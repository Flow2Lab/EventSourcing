<?php
namespace Flow2Lab\EventSourcing\Projection\Command;

use Flow2Lab\EventSourcing\Projection\AbstractProjector;
use Flow2Lab\EventSourcing\Projection\ProjectionBuilder;
use Flow2Lab\EventSourcing\Projection\ProjectorInterface;
use Flow2Lab\EventSourcing\Store\Backend\EventStoreBackend;
use Flow2Lab\EventSourcing\Store\Backend\Exception\EventStreamNotFoundException;
use Doctrine\DBAL\DBALException;
use TYPO3\Flow\Cli\CommandController;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\Flow\Object\ObjectManagerInterface;

class ProjectionCommandController extends CommandController
{

    /**
     * @var ProjectionBuilder
     * @Flow\Inject
     */
    protected $projectionBuilder;

    /**
     * @var EventStoreBackend
     * @Flow\Inject
     */
    protected $store;

    /**
     * @var ObjectManagerInterface
     * @Flow\Inject
     */
    protected $objectManager;

    /**
     * Lists projections with their projectors and the count
     */
    public function listProjectionsCommand()
    {
        $projectorClassNames = $this->reflectionService->getAllImplementationClassNamesForInterface(ProjectorInterface::class);
        $projections = [];

        foreach ($projectorClassNames as $projectorClassName) {
            $projector = $this->getProjectorByName($projectorClassName);

            try {
                $count = $projector->countAll();
            } catch (DBALException $e) {
                $count = 'n/a';
            }

            $projections[] = [
                'projection' => $projector->getProjectionClassName(),
                'projector' => $projectorClassName,
                'count' => $count
            ];
        }

        $this->output->outputTable($projections, [
            'Projection', 'Projector', 'Count'
        ]);
    }

    /**
     * Clears and rebuilds the projection persistence structure
     *
     * @param string $projectorName
     */
    public function buildProjectionCommand($projectorName)
    {
        $projector = $this->getProjectorByName($projectorName);
        $projector->build();
    }

    /**
     * Replays projections for a given projector and stream
     *
     * @param string $projectorName
     * @param string $eventStreamName
     * @throws EventStreamNotFoundException
     */
    public function replayProjectionCommand($projectorName, $eventStreamName)
    {
        $projector = $this->getProjectorByName($projectorName);
        $stream = $this->store->load($eventStreamName);

        $projector->build();
        foreach ($stream as $event) {
            if ($projector->canHandleEvent($event)) {
                $projector->handle($event);
            }
        }
    }

    public function replayAllProjectionsCommand()
    {
        $projectorClassNames = $this->reflectionService->getAllImplementationClassNamesForInterface(ProjectorInterface::class);
        // todo: find a better way of doing this

        try {
            $stream = $this->store->load('events');
        } catch (EventStreamNotFoundException $e) {
            $stream = [];
        }

        /** @var AbstractProjector[] $projectors */
        $projectors = [];
        foreach ($projectorClassNames as $projectorClassName) {
            $projector = $this->getProjectorByName($projectorClassName);

            try {
                $projector->build();
                $projectors[] = $projector;
            } catch (\Exception $e) {
                $this->outputLine('Unable to build projection table for projector "' . $projectorClassName . '": ' . $e->getMessage());
            }
        }

        foreach ($stream as $event) {
            foreach ($projectors as $projector) {
                if ($projector->canHandleEvent($event)) {
                    $projector->handle($event);
                }
            }
        }
    }

    /**
     * @param string $projectorName
     * @return ProjectorInterface
     */
    protected function getProjectorByName($projectorName)
    {
        return $this->objectManager->get($projectorName);
    }

}