<?php

namespace Application\Lib\Database;

require_once('../src/classes/dotenv.php');
use Dotenv\DotEnv;


class DatabaseConnection
{
    public ?\PDO $database = null;

    public function getConnection(): \PDO
    {

        (new DotEnv("../.env"))->load();
        $host = getenv('HOST');
        $user = getenv('USER');
        $port = getenv('PORT');
        $password = getenv('PASSWORD');
        $dbname = getenv('DBNAME');
        if ($this->database === null) {
            $this->database = new \PDO('mysql:host='.$host.':'.$port.';dbname='.$dbname.';charset=utf8', $user, $password);
            
        }

        return $this->database;
    }
}
