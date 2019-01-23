<?php

namespace Flow\StateStore;

use PDO;

class PdoStateStore implements StateStoreInterface
{
    protected $pdo;
    protected $tablename;

    public function __construct(PDO $pdo, $tableName = 'states')
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

    public function setState(string $stateId, array $state)
    {
        $sql = sprintf(
            'INSERT INTO %s
            (id, data) VALUES (:id, :data)
            ON DUPLICATE KEY UPDATE
            data=:data',
            $this->tableName
        );
        $data = json_encode(
            $state,
            JSON_UNESCAPED_SLASHES
        );

        $statement = $this->pdo->prepare($sql);
        $arguments = [
            ':id' => $stateId,
            ':data' => $data,
        ];
        $res = $statement->execute($arguments);
    }

    public function getState(string $stateId)
    {
        $sql = sprintf(
            'SELECT data FROM %s WHERE id=:id',
            $this->tableName
        );

        $statement = $this->pdo->prepare($sql);
        $statement->execute([':id'=>$stateId]);
        $row = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return [];
        }
        return json_decode($row['data'], true);
    }
}
