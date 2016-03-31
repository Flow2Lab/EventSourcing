<?php
namespace Flow2Lab\EventSourcing\Projection\Hydration;

class ArrayHydrator implements HydratorInterface
{

    /**
     * @param array $row
     * @return array
     */
    public function hydrate(array $row)
    {
        return $row;
    }

}