<?php
namespace Flow2Lab\EventSourcing\Serializer;

use Flow2Lab\EventSourcing\Message;

interface MessageSerializerInterface
{

    /**
     * @param Message $message
     * @return mixed
     */
    public function serialize(Message $message);

    /**
     * @param mixed $serializedMessage
     * @return Message
     */
    public function unserialize($serializedMessage);

}