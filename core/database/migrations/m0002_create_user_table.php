<?php

use app\core\Migration;
use app\core\database\Database;

class m0002_create_user_table extends Migration
{

    public function up(Database $db)
    {
        $sql = "CREATE TABLE users(
        user_id int(11) primary key auto_increment not null,
    user_name varchar(128) not null,
    user_email varchar(128) not null,
    user_uid varchar(128) not null,
    user_pwd varchar(128) not null);";

        try {
            $db->queryExecute($sql);
            echo "User table created" . PHP_EOL;
        } catch (PDOException $error) {
            echo "ERROR" . $error . PHP_EOL;
        }

    }

    public function down(Database $db)
    {
        $sql = "DROP TABLE users;";

        try {
            $db->queryExecute($sql);
            echo "User table deleted" . PHP_EOL;
        } catch (PDOException $error) {
            echo "ERROR" . $error . PHP_EOL;
        }
    }
}