<?php

namespace app\core;

use app\core\database\Database;

abstract class Migration
{
    public abstract function up(Database $db);

    public abstract function down(Database $db);

}