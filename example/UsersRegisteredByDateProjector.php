<?php

namespace Flow\Example;

use Flow\Projector\AbstractStateProjector;

class UsersRegisteredByDateProjector extends AbstractStateProjector
{

    public function project(array $event)
    {

        $state = $this->stateStore->getState('users-registered-by-date');
        $date = $event['createdAt'];

        switch ($event['type']) {
            case 'user:registered':
                if (!isset($state[$date])) {
                    $state[$date] = 0;
                }
                $state[$date]+=1;
                break;
        }
        $this->stateStore->setState('users-registered-by-date', $state);
    }
}
