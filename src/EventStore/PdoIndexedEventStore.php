<?php

namespace Flow\EventStore;

use PDO;

class PdoIndexedEventStore extends PdoEventStore implements EventStoreInterface
{
    protected $mapping;

    public function __construct(PDO $pdo, $tableName = 'events', array $mapping = [])
    {
        parent::__construct($pdo, $tableName);
        $this->mapping = $mapping;
    }

    public function addEvent(array $event)
    {
        $sql = sprintf(
            'INSERT INTO %s
            (data, %s) VALUES (:data, %s)',
            $this->tableName,
            implode(', ', $this->mapping),
            ':' . implode(', :',  $this->mapping)
        );
        $data = json_encode(
            $event,
            JSON_UNESCAPED_SLASHES
        );

        $statement = $this->pdo->prepare($sql);
        $arguments = [
            ':data' => $data,
        ];
        foreach ($this->mapping as $k=>$v) {
            $arguments[':' . $v] = $event[$k] ?? null;
        }
        $res = $statement->execute($arguments);
    }

    public function getEventsWhere(array $conditions)
    {
        $where = '';
        $arguments = [];
        foreach ($conditions as $key=>$value) {
            if ($where) {
                $where .= ' AND ';
            }
            $where .= $key . '=:' . $key;
            $arguments[$key] = $value;
        }
        $sql = sprintf(
            'SELECT data FROM %s WHERE %s',
            $this->tableName,
            $where
        );

        $statement = $this->pdo->prepare($sql);
        $statement->execute($arguments);
        $events = [];
        foreach ($statement->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $event = json_decode($row['data'], true);
            $events[] = $event;
        }
        return $events;
    }

}
