<?php

$events = [];

$events[] = [
    'type' => 'user:registered',
    'user' => 'joe',
    'ip' => '1.2.3.4',
    'createdAt' => '2018-01-01 12:00:00',
    'createdBy' => 'joe',
    'firstname' => 'Joe',
    'lastname' => 'Johnson',
    'email' => 'joe@example.com',
];

$events[] = [
    'type' => 'user:emailUpdated',
    'user' => 'joe',
    'ip' => '9.9.9.9',
    'createdAt' => '2018-01-02 13:10:00',
    'email' => 'jjohnson@example.com',
];

$events[] = [
    'type' => 'user:addressAdded',
    'user' => 'joe',
    'ip' => '9.9.9.9',
    'createdAt' => '2018-01-03 13:10:00',
    'street' => 'Example lane 1',
    'postalcode' => '90210',
    'city' => 'Beverly Hills',
];

$events[] = [
    'type' => 'order:created',
    'customer' => 'joe',
    'agent' => 'alice',
    'order' => '1',
    'ip' => '9.9.9.9',
    'createdAt' => '2018-01-03 13:10:00',
    'user' => 'joe',
];


$events[] = [
    'type' => 'order:addProduct',
    'customer' => 'joe',
    'agent' => 'alice',
    'order' => '1',
    'ip' => '9.9.9.9',
    'createdAt' => '2018-01-03 13:10:00',
    'product' => 'bbq',
    'unitPrice' => 34.95,
    'quantity' => 1,
];

$events[] = [
    'type' => 'order:addProduct',
    'customer' => 'joe',
    'agent' => 'alice',
    'order' => '1',
    'ip' => '9.9.9.9',
    'createdAt' => '2018-01-03 13:10:00',
    'product' => 'bucket',
    'unitPrice' => 14.95,
    'quantity' => 2,
];


$events[] = [
    'type' => 'user:addressAdded',
    'user' => 'joe',
    'ip' => '1.2.3.4',
    'createdAt' => '2018-01-04 13:10:00',
    'street' => 'Demo lane 1',
    'postalcode' => '1234XY',
    'city' => 'Demoville',
];

$events[] = [
    'type' => 'user:addressRemoved',
    'ip' => '9.9.9.9',
    'createdAt' => '2018-01-05 13:10:00',
    'user' => 'joe',
    'index' => 0,
];


