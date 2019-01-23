<?php

namespace Flow\Example;

use Flow\Projector\AbstractStateProjector;

class IpProjector extends AbstractStateProjector
{
    public function project(array $event)
    {
        if (!isset($event['ip'])) {
            return;
        }

        $stateId = 'ip:' . $event['ip'];

        $state = $this->getState($stateId);

        if (!isset($state['eventCount'])) {
            $state['eventCount'] = 0;
        }
        $state['eventCount']++;
        $this->setState($stateId, $state);
    }
}
