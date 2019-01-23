<?php

namespace Flow\Projector;

use Flow\StateStore\StateStoreInterface;

abstract class AbstractStateProjector implements ProjectorInterface
{
    protected $stateStore;

    public function __construct(StateStoreInterface $stateStore)
    {
        $this->stateStore = $stateStore;
    }

    public function project(array $event)
    {
        // No-op
    }

    public function getState(string $stateId)
    {
        return $this->stateStore->getState($stateId);
    }

    public function setState(string $stateId, array $state)
    {
        $this->stateStore->setState($stateId, $state);
    }
}
