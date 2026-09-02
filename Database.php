<?php

class Database {
    private PDO $connection;

    public function __construct($config, $username, $password)
    {
        $dsn = "pgsql:" . http_build_query(data: $config, arg_separator: ';');

        $this->connection = new PDO(
            dsn: $dsn,
            username: $username,
            password: $password,
            options: [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
        );
    }

    public function query(string $query, array $params = []): false|PDOStatement
    {
        $statement = $this->connection->prepare($query);

        $statement->execute($params);

        return $statement;
    }

    public function fetchAll(string $query, array $params = []): array
    {
        return $this->query($query, $params)->fetchAll();
    }

    public function fetch(string $query, array $params = []): array|false
    {
        return $this->query($query, $params)->fetch();
    }

    public function lastInsertId(): string
    {
        return $this->connection->lastInsertId();
    }
}
