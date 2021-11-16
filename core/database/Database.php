<?php

namespace app\core\database;

use PDO;
use PDOException;

class Database
{
    private string $host;
    private string $user;
    private string $dbname;
    private string $dsn;
    private string $password;

    private PDO $dbh;
    private $stmt;
    private string $error;


    public function __construct()
    {
        $this->setDbDetails();

//        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->dbh = new PDO($this->dsn, $this->user, $this->password, $options);
        } catch (PDOException $error) {
            $this->error = $error->getMessage();
            echo $this->error;
        }
    }

    /**
     * @return PDO
     */
    public function getDbh(): PDO
    {
        return $this->dbh;
    }

    public function setDbDetails()
    {

        $this->host = 'localhost';
        $this->dsn = $_ENV['DB_DSN'];
        $this->dbname = $_ENV['DB_USER'];
        $this->user = $_ENV['DB_USER'];
        $this->password = $_ENV['DB_PASSWORD'];

    }

    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function resultSet()
    {
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function single()
    {
        $this->stmt->excute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }

    public function bindMultipleValues($values)
    {
        foreach ($values as $param => $value) {
            $this->bind($param, $value);
            echo $param . "=" . $value . '<br>';
        }

    }

    public function queryExecute($sql)
    {
        $this->dbh->exec($sql);
    }

    public function fetchAllColumns()
    {
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}