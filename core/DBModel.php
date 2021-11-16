<?php

namespace app\core;

use app\core\database\Database;

abstract class DBModel
{
    protected Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }


    protected abstract function getTableName(): string;

    protected abstract function getAttributes(): array;

    protected abstract function getPrimaryKey(): string;

    protected abstract function getData(): array;

    protected abstract function getPrimaryValue(): string;

    public function save(): bool
    {
        $tableName = $this->getTableName();
        $attributes = $this->getAttributes();
        $values = array_map(fn($attr) => ":$attr", $attributes);
        $data = $this->getData();

        $sql = "INSERT INTO $tableName(" . implode(',', $attributes) . ")VALUES(" . implode(',', $values) . ")";

        /*enter the data to database*/
        try {
            $this->db->query($sql);
            $this->db->bindMultipleValues($data);
            $this->db->execute();

            return true;

        } catch (\PDOException $error) {
            echo "ERROR " . $error->getMessage();

            return false;
        }
    }

    public function update(): bool
    {
        $tableName = $this->getTableName();
        $attributes = $this->getAttributes();
        $values = array_map(fn($attr) => "$attr = :$attr", $attributes);

        $data = $this->getData();
        $primaryValue = $this->getPrimaryValue();
        $primaryKey = $this->getPrimaryKey();

        $data["primaryValue"] = $primaryValue;

        $sql = " UPDATE $tableName SET " . implode(',', $values) . "  WHERE $primaryKey = :primaryValue;";

        try {
            $this->db->query($sql);
            $this->db->bindMultipleValues($data);
            $this->db->execute();

            return true;

        } catch (\PDOException $error) {
            echo "ERROR " . $error->getMessage();

            return false;
        }
    }
}