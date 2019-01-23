<?php

namespace Flow\Projector;

class MultiProjector implements ProjectorInterface
{
    public function __construct(array $projectors)
    {
        $this->projectors = $projectors;
    }

    public function project(array $event)
    {
        foreach ($this->projectors as $projector) {
            $projector->project($event);
        }
    }
}
