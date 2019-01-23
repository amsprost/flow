<?php

namespace Flow\Example;

use Flow\Projector\AbstractStateProjector;

class OrderProjector extends AbstractStateProjector
{
    public function project(array $event)
    {
        if (!isset($event['order'])) {
            return;
        }

        $stateId = 'order:' . $event['order'];

        $state = $this->getState($stateId);

        switch ($event['type']) {
            case 'order:created':
                $state['user'] = ['$ref' => 'user:' . $event['user']] ?? null;
                $state['lines'] = [];
                $state['price'] = 0;
                break;
            case 'order:addProduct':
                $line = [
                    'product' => ['$ref' => 'product:' . $event['product']],
                    'quantity' => $event['quantity'],
                    'unitPrice' => $event['unitPrice'],
                ];
                $state['price'] += $line['quantity'] * $line['unitPrice'];
                $state['lines'][] = $line;
                break;
        }
        $this->setState($stateId, $state);
    }
}
