<?php

namespace Flow\Example;

use Symfony\Component\Dotenv\Dotenv;
use Connector\Connector;
use PDO;

require_once __DIR__ . '/../vendor/autoload.php';

include __DIR__ . '/events.php';

$filename = '.env';
if (file_exists($filename)) {
    $dotenv = new Dotenv();
    $dotenv->load($filename);
}


// Helper function to pretty-print multi-dimensional arrays as JSON
function dump($data)
{
    $json = json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_SLASHES);
    echo $json . PHP_EOL;
}

// Instantiate the event and state stores

$dsn = getenv('FLOW_EXAMPLE_DSN');

if (!$dsn) {
    // No database DSN available, use in-memory event- and state stores.
    $eventStore = new \Flow\EventStore\ArrayEventStore();
    $stateStore = new \Flow\StateStore\ArrayStateStore();

} else {
    // Get PDO connection from DSN, and instantiate PDO-based event- and state stores
    $connector = new Connector();
    $config = $connector->getConfig($dsn);
    $pdo = $connector->getPdo($config);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //$eventStore = new \Flow\EventStore\PdoEventStore($pdo, 'events');
    $eventStore = new \Flow\EventStore\PdoIndexedEventStore($pdo, 'events_with_type_and_user', ['type' => 'event_type', 'user'=>'user']);
    $stateStore = new \Flow\StateStore\PdoStateStore($pdo);
}

$eventStore->clear(); // Clear any prior events
$stateStore->clear(); // Clear any prior states

// Load events from array into the eventstore
foreach ($events as $event) {
    $eventStore->addEvent($event);
}

// Instantiate projectors
$userProjector = new \Flow\Example\UserProjector($stateStore);
$orderProjector = new \Flow\Example\OrderProjector($stateStore);
$userOrderProjector = new \Flow\Example\UserOrderProjector($stateStore);
$ipProjector = new \Flow\Example\IpProjector($stateStore);
$reportProjector = new \Flow\Example\UsersRegisteredByDateProjector($stateStore);

// Combine projectors into a multi projector
$projector = new \Flow\Projector\MultiProjector([$userProjector, $orderProjector, $userOrderProjector, $ipProjector, $reportProjector]);


// Get all events from the event store
//$events = $eventStore->getEvents();
$events = $eventStore->getEventsWhere(['user'=>'joe']);

// Project all events
foreach ($events as $event) {
    $projector->project($event);
}

// Display states as JSON to stdout
dump($stateStore->getState('user:joe'));
dump($stateStore->getState('order:1'));
dump($stateStore->getState('ip:9.9.9.9'));
dump($stateStore->getState('users-registered-by-date'));
