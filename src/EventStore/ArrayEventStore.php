<?php

namespace Flow\EventStore;

class ArrayEventStore implements EventStoreInterface
{
    protected $events = [];

    public function addEvent(array $event)
    {
        $this->events[] = $event;
    }

    public function getAllEvents()
    {
        return $this->events;
    }

    public function clear()
    {
        $this->events = [];
    }
}
