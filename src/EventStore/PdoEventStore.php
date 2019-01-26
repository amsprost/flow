<?php

namespace Flow\EventStore;

use PDO;

class PdoEventStore implements EventStoreInterface
{
    protected $pdo;
    protected $tablename;

    public function __construct(PDO $pdo, $tableName = 'events')
    {
        $this->pdo = $pdo;
        $this->tableName = $tableName;
    }

    public function clear()
    {
        $sql = sprintf(
            'TRUNCATE %s',
            $this->tableName
        );

        $statement = $this->pdo->prepare($sql);
        $res = $statement->execute();
    }

    public function addEvent(array $event)
    {
        $sql = sprintf(
            'INSERT INTO %s
            (data) VALUES (:data)',
            $this->tableName
        );
        $data = json_encode(
            $event,
            JSON_UNESCAPED_SLASHES
        );

        $statement = $this->pdo->prepare($sql);
        $arguments = [
            ':data' => $data,
        ];
        $res = $statement->execute($arguments);
    }

    public function getEvents()
    {
        $sql = sprintf(
            'SELECT data FROM %s',
            $this->tableName
        );

        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        $events = [];
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $event = json_decode($row['data'], true);
            $events[] = $event;
        }
        return $events;
    }

    public function getEventsWhere(array $conditions)
    {
        $events = $this->getAllEvents();
        $res = [];
        foreach ($events as $event) {
            $match = true;
            foreach ($conditions as $key=>$value) {
                if ($event[$key] != $value) {
                    $match = false;
                }
            }
            if ($match) {
                $res[] = $event;
            }
        }
        return $res;
    }
}
