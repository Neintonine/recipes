<?php
declare(strict_types=1);

namespace RecipeManager\Database;

use PDO;
use PDOStatement;
use RecipeManager\Path;

final class Database
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = $this->connect();
    }

    public function query(string $query): false|PDOStatement {
        $params = func_get_args();
        array_shift($params);
        $statement = $this->connection->prepare($query);
        $statement->execute($params);
        return $statement;
    }

    private function connect(): PDO
    {
        /**
         * @var array{address: string, database: string, user: string, password: string} $settings
         */
        [
            'address' => $address,
            'database' => $database,
            'user' => $user,
            'password' => $password
        ] = json_decode(file_get_contents(Path::PHP_CONFIG_PATH . '/database.json'), true);

        $dsn = "mysql:host=$address;dbname=$database";
        return new PDO($dsn, $user, $password);
    }
}