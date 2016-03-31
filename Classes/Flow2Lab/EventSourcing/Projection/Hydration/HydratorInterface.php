<?php
namespace Flow2Lab\EventSourcing\Projection\Hydration;

interface HydratorInterface
{

    /**
     * @param array $row
     * @return mixed
     */
    public function hydrate(array $row);

}