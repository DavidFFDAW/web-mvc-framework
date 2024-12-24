<?php

class Db extends PDO
{
    private static $instance = null;

    private function __construct()
    {
        $databaseDatas = [
            'host' => 'localhost',
            'dbname' => getenv('DB_NAME'),
            'user' => getenv('DB_USER'),
            'password' => getenv('DB_PWD'),
        ];

        parent::__construct(
            "mysql:host=" . $databaseDatas['host'] . ";dbname=" . $databaseDatas['dbname'],
            $databaseDatas['user'],
            $databaseDatas['password']
        );
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->exec('SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci');
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new DB();
        }
        return self::$instance;
    }
}
