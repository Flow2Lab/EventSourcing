<?php
namespace Flow2Lab\EventSourcing;

use TYPO3\Flow\Utility\Algorithms;

class Uuid
{

    static public function next()
    {
        return Algorithms::generateUUID();
    }

    protected function __construct()
    {
    }

}