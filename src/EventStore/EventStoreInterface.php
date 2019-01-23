<?php

namespace Flow\EventStore;

interface EventStoreInterface
{
    public function addEvent(array $event);
    /**
     * Return array of all events
     */
    public function getAllEvents();

    public function clear();
}
