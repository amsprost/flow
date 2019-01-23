<?php

namespace Flow\Example;

use Flow\Projector\AbstractStateProjector;

class UserOrderProjector extends AbstractStateProjector
{
    public function project(array $event)
    {
        if (!isset($event['customer'])) {
            return;
        }

        $stateId = 'user:' . $event['customer'];

        $state = $this->getState($stateId);

        switch ($event['type']) {
            case 'order:created':
                if (!isset($state['orders'])) {
                    $state['orders'] = [];
                }
                $state['orders'][] = ['$ref' => $event['order']];
                break;
        }
        $this->setState($stateId, $state);
    }
}
