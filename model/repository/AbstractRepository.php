<?php

namespace model\repository;

use PDO;

class AbstractRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function execute($query, $params = []): \PDOStatement
    {
        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        return $statement;
    }

    public function executeInsert($query, $params = []): int
    {
        $this->execute($query, $params);
        return $this->getLastInsertedId();
    }

    public function executeUpdate($query, $params = []): int
    {
        $statement = $this->execute($query, $params);
        return $statement->rowCount();
    }

    public function fetchAllAssoc($query, $params = []): ?array
    {
        $result = $this->execute($query, $params)->fetchAll(PDO::FETCH_ASSOC);
        if (! $result) {
            return null;
        }
        return $result;
    }

    public function fetchRowAssoc($query, $params = []): ?array
    {
        $result = $this->execute($query, $params)->fetch(PDO::FETCH_ASSOC);
        if (! $result) {
            return null;
        }
        return $result;
    }

    public function getLastInsertedId(): int
    {
        return (int) $this->connection->lastInsertId();
    }

    protected function beginTransaction()
    {
        $this->connection->beginTransaction();
    }

    protected function commitTransaction(): bool
    {
        return $this->connection->commit();
    }

    protected function rollbackTransaction(): bool
    {
        return $this->connection->rollBack();
    }

    protected function inTransaction(): bool
    {
        return $this->connection->inTransaction();
    }
}