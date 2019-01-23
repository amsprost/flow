<?php

namespace Flow\StateStore;

interface StateStoreInterface
{
    public function getState(string $stateId);

    public function setState(string $stateId, array $state);

    public function clear();
}
