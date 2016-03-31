<?php
namespace Flow2Lab\EventSourcing\Queue;

interface QueueInterface
{

    /**
     * @param Message $message
     * @return void
     */
    public function queue(Message $message);

}