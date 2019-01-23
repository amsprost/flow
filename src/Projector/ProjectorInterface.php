<?php

namespace Flow\Projector;

interface ProjectorInterface
{
    /**
     * Project a single event
     */
    public function project(array $event);
}
