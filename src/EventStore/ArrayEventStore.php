<?php

namespace Flow\EventStore;

class ArrayEventStore implements EventStoreInterface
{
    protected $events = [];

    public function addEvent(array $event)
    {
        $this->events[] = $event;
    }

    public function getEvents()
    {
        return $this->events;
    }

    public function getEventsWhere(array $conditions)
    {
        $events = $this->getEvents();
        $res = [];
        foreach ($events as $event) {
            $match = true;
            foreach ($conditions as $key=>$value) {
                if (($event[$key] ?? null) != $value) {
                    $match = false;
                }
            }
            if ($match) {
                $res[] = $event;
            }
        }
        return $res;
    }

    public function clear()
    {
        $this->events = [];
    }
}
