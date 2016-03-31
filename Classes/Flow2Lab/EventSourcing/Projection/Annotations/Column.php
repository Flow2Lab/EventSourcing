<?php
namespace Flow2Lab\EventSourcing\Projection\Annotations;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class Column
{

    /**
     * @var string
     */
    public $definition;

    /**
     * @param array $values
     */
    public function __construct(array $values)
    {
        if (isset($values['definition']) || isset($values['value'])) {
            $this->definition = isset($values['definition']) ? $values['definition'] : $values['value'];
        }
    }

}