<?php

require_once __DIR__ . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

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

        $files = $this->filesInMigration();

        $toApplyMigrations = $this->toApplyMigrations($appliedMigrations, $files);

        foreach ($toApplyMigrations as $migration) {
            if ($migration === '.' || $migration === '..') {
                continue;
            }
            require_once __DIR__ . '/core/database/migrations/' . $migration;


            $className = pathinfo($migration, PATHINFO_FILENAME);


            $this->log("Applying migrations $migration");
            $instance = new $className();
            $instance->up($this->db);
            $this->log("Applied migrations $migration");


            $newMigrations[] = $migration;
        }

        if (!empty($newMigrations))
            $this->saveMigrations($newMigrations);
        else
            $this->log("All migrations are applied");


    }

    public function dropAll()
    {
        $appliedMigrations = $this->getAppliedMigrations();
        $removedTables = [];

        foreach ($appliedMigrations as $mig) {
            require_once __DIR__ . '/core/database/migrations/' . $mig;
            $className = pathinfo($mig, PATHINFO_FILENAME);
            $this->log("Dropping table : $mig");
            $instance = new $className();
            $instance->down($this->db);
            $this->log("Table dropped : $mig");
            array_push($removedTables, $mig);
        }

        $this->saveRemoves($removedTables);
    }

    public function drop($name)
    {
        if (strlen($name) !== 5) {
            echo "name incorrect name length must be 5 characters" . PHP_EOL;
            return;
        }

        $appliedMigrations = $this->getAppliedMigrations();
        $removedTables = [];

        foreach ($appliedMigrations as $mig) {
            if (substr($mig, 0, 5) === "$name") {
                require_once __DIR__ . '/core/database/migrations/' . $mig;
                $className = pathinfo($mig, PATHINFO_FILENAME);
                $this->log("Dropping table : $mig");
                $instance = new $className();
                $instance->down($this->db);
                $this->log("Table dropped : $mig");
                array_push($removedTables, $mig);
                return;
            }
        }
        $this->saveRemoves($removedTables);
        echo "Couldn't find that migration" . PHP_EOL;
    }

    public function view()
    {
        /*not migrated*/
        $this->log("============================================================");
        $migrated = $this->getAppliedMigrations();
        $files = $this->filesInMigration();
        foreach ($this->toApplyMigrations($migrated, $files) as $mig) {
            if ($mig === '.' || $mig === '..') {
                continue;
            }
            $this->viewLine(pathinfo($mig, PATHINFO_FILENAME) . ' - not migrated');
        }

        $this->log("============================================================");
        /*migrated*/

        foreach ($migrated as $mig) {
            $this->viewLine(pathinfo($mig, PATHINFO_FILENAME) . ' - migrated');
        }
    }

    private function toApplyMigrations($applied, $all): array
    {
        return array_diff($all, $applied);
    }

    private function filesInMigration()
    {
        return scandir(__DIR__ . '/core/database/migrations');
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

    private function saveMigrations(array $migrations)
    {
        $str = implode(',', array_map(fn($m) => "('$m')", $migrations));
        $sql = "INSERT INTO migrations(migration) VALUES $str";

        $this->db->queryExecute($sql);
    }

    private function saveRemoves(array $migrations)
    {
        if (empty($migrations))
            return;

        $str = implode(',', array_map(fn($m) => "('$m')", $migrations));
        $sql = "DELETE FROM migrations WHERE migration IN ($str);";

        $this->db->queryExecute($sql);
    }

    private function log($message)
    {
        echo '[' . date('Y-m-d H:i:s') . '] - ' . $message . PHP_EOL;
    }

    private function viewLine($message)
    {
        echo '[ ' . $message . ' ]' . PHP_EOL;
    }
}


// position [0] is the script's file name
array_shift($argv);

$funcName = array_shift($argv);
$param = array_shift($argv) ?? null;

echo "Calling Migrate::$funcName ...\n";
$classObj = new Migrate();

/*call_user_func_array(array($className, $funcName), $argv);*/
$classObj->$funcName($param);

