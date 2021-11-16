<?php


use app\core\Migration;
use app\core\database\Database;

class m0001_initial extends Migration
{

    public function up(Database $db)
    {


        echo "migrations applied on up function m0001_initial" . PHP_EOL;
    }

    public function down(Database $db)
    {
        // TODO: Implement down() method.
    }
}