<?php

namespace app\core\database;

use PDO;
use PDOException;

class Database
{
    private string $host = 'localhost';
    private string $user = 'root';
    private string $dbname = 'login_system';


    private PDO $dbh;
    private $stmt;
    private string $error;


    public function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->dbh = new PDO($dsn, $this->user, "root", $options);
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
}