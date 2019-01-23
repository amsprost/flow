<?php

namespace Flow\StateStore;

class ArrayStateStore implements StateStoreInterface
{
    protected $states = [];

    public function getState(string $key)
    {
        return $this->states[$key] ?? [];
    }

    public function setState(string $key, array $state)
    {
        $this->states[$key] = $state;
    }

    public function clear()
    {
        $this->states = [];
    }
}
