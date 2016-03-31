<?php
namespace Flow2Lab\EventSourcing\Command;

use Flow2Lab\EventSourcing\Uuid;

class Command implements CommandInterface
{

    /**
     * @var string
     */
    public $commandId;

    public function __construct()
    {
        $this->commandId = Uuid::next();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return get_class($this) . ':' . $this->commandId;
    }

}