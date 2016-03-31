<?php
namespace Flow2Lab\EventSourcing;

use TYPO3\Flow\Core\Bootstrap;
use TYPO3\Flow\Package\Package as BasePackage;

/**
 * The EventSourcing Package
 */
class Package extends BasePackage
{

    /**
     * @var boolean
     */
    protected $protected = TRUE;

    /**
     * Invokes custom PHP code directly after the package manager has been initialized.
     *
     * @param Bootstrap $bootstrap The current bootstrap
     * @return void
     */
    public function boot(Bootstrap $bootstrap)
    {
        $dispatcher = $bootstrap->getSignalSlotDispatcher();

        # Command Auditing
        $dispatcher->connect('Flow2Lab\EventSourcing\Command\Bus\InternalCommandBus', 'commandHandlingSuccess', 'Flow2Lab\EventSourcing\Auditing\CommandLogger', 'onCommandHandlingSuccess');
        $dispatcher->connect('Flow2Lab\EventSourcing\Command\Bus\InternalCommandBus', 'commandHandlingFailure', 'Flow2Lab\EventSourcing\Auditing\CommandLogger', 'onCommandHandlingFailure');

        # Event Auditing
        $dispatcher->connect('Flow2Lab\EventSourcing\Event\Bus\InternalEventBus', 'eventHandlingSuccess', 'Flow2Lab\EventSourcing\Auditing\EventLogger', 'onEventHandlingSuccess');
        $dispatcher->connect('Flow2Lab\EventSourcing\Event\Bus\InternalEventBus', 'eventHandlingFailure', 'Flow2Lab\EventSourcing\Auditing\EventLogger', 'onEventHandlingFailure');
        $dispatcher->connect('Flow2Lab\EventSourcing\Event\Bus\InternalEventBus', 'eventQueueingSuccess', 'Flow2Lab\EventSourcing\Auditing\EventLogger', 'onEventQueueingSuccess');

    }
}
