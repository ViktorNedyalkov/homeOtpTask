<?php

namespace model\repository;

use \PDO;

class Connection
{
    private static ?Connection $instance = null;
    private PDO $pdo;

    private function __construct()
    {

        $configArray = parse_ini_file($_SERVER['DOCUMENT_ROOT'] . '/config.ini.php');

        $this->pdo = new PDO('mysql:host=' . $configArray['DATABASE_IP'] . ':' . $configArray['DATABASE_PORT'] . ';dbname=' .
            $configArray['DATABASE_NAME'], $configArray['DATABASE_USER'], $configArray['DATABASE_PASSWORD']);

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    }

    public static function getInstance(): Connection
    {
        if (self::$instance === null) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }

    public function getConnection(): PDO
    {
        return $this->pdo;
    }
}