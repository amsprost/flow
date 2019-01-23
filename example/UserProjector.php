<?php

namespace Flow\Example;

use Flow\Projector\AbstractStateProjector;

class UserProjector extends AbstractStateProjector
{
    public function project(array $event)
    {
        if (!isset($event['user'])) {
            return;
        }

        $stateId = 'user:' . $event['user'];

        $state = $this->getState($stateId);

        switch ($event['type']) {
            case 'user:registered':
                $state['firstname'] = $event['firstname'] ?? null;
                $state['lastname'] = $event['lastname'] ?? null;
                $state['email'] = $event['email'] ?? null;
                $state['addresses'] = [];
                break;
            case 'user:emailUpdated':
                $state['email'] = $event['email'] ?? null;
                break;
            case 'user:addressAdded':
                $key = (string)count($state['addresses']);
                $state['addresses'][$key] = [
                    'street' => $event['street'] ?? null,
                    'city' => $event['city'] ?? null,
                    'postalcode' => $event['postalcode'] ?? null,
                ];
                break;
            case 'user:addressRemoved':
                array_splice($state['addresses'], $event['index'], 1);
                break;
        }
        $this->setState($stateId, $state);
    }
}
