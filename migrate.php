<?php

require_once __DIR__ . '/vendor/autoload.php';

use app\core\database\Database;

class Migrate
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function apply()
    {
        $this->createMigrationTable();
        $appliedMigrations = $this->getAppliedMigrations();

        $newMigrations = [];

//        $files = scandir()


        echo "hello" . PHP_EOL;
    }

    private function createMigrationTable()
    {
        $this->db->queryExecute(
            "create table if not exists migrations (
                id int auto_increment primary key,
                migration varchar(255),
                created_at timestamp default current_timestamp 
                ) engine=INNODB;"
        );
    }

    private function getAppliedMigrations(): array
    {
        $this->db->query("select migration from migrations");
        $this->db->execute();

        return $this->db->fetchAllColumns();
    }

}


// position [0] is the script's file name
array_shift($argv);

$funcName = array_shift($argv);

echo "Calling Migrate::$funcName ...\n";
$classObj = new Migrate();

/*call_user_func_array(array($className, $funcName), $argv);*/
$classObj->$funcName();

