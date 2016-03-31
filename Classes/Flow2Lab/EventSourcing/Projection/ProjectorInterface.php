<?php
namespace Flow2Lab\EventSourcing\Projection;

use Flow2Lab\EventSourcing\Event\Handler\EventHandlerInterface;

interface ProjectorInterface extends EventHandlerInterface
{

    /**
     * @return string FQCN of the Projection class
     */
    public function getProjectionClassName();

    /**
     * Clears and rebuilds the projection persistence structure
     *
     * @return void
     */
    public function build();

    /**
     * @param string $identifier
     * @return object
     */
    public function findById($identifier);

    /**
     * @return integer
     */
    public function countAll();

    /**
     * Deletes the projection for the given identifier (if available)
     *
     * @param string $identifier
     * @return void
     */
    public function deleteById($identifier);

}