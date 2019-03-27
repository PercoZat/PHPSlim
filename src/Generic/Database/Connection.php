<?php
namespace Generic\Database;

class Connection
{
    private $pdo;

    public function __construct(string $databaseName, string $databaseUser, string $databasePass)
    {
        $dsn = 'mysql:host=localhost;dbname='.$databaseName;
        $this->connect($dsn, $databaseUser, $databasePass);
    }

    private function connect(string $dsn, string $user, string $pass): void
    {
        try {
            $this->pdo = new \PDO($dsn, $user, $pass, [
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET names utf8"
            ]);
        } catch (\PDOException $e) {
            echo "Erreur lors de la connexion : " . $e->getMessage() . "<br/>";
            die();
        }
    }

    public function query(string $query): array
    {
        $pdoStatement = $this->pdo->query($query);
        return $pdoStatement->fetchAll();
    }

    public function findTable(string $tableName): array
    {
        // Préparation
        $query = "SELECT * FROM ".$tableName;
        $statement = $this->pdo->prepare($query);

        // Execution
        $statement->execute();
        return $statement->fetchAll();
    }

}