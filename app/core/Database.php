<?php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $instance = null;
    private $pdo;

    private function __construct()
    {
        $server_ips = ['192.168.111.240'];
        $current_host = $_SERVER['HTTP_HOST'] ?? '';
        $current_server_addr = $_SERVER['SERVER_ADDR'] ?? ($_SERVER['LOCAL_ADDR'] ?? '');
        $is_server = in_array($current_server_addr, $server_ips, true)
            || strpos($current_host, '192.168.111.240') === 0;

        $db = 'pdhfoundation';
        if ($is_server) {
            $host = 'localhost';
            $user = 'webtomdb';
            $pass = '@TOM$DataBase10832';
        } else {
            $host = '192.168.111.240';
            $user = 'tomwebdbnavicat';
            $pass = '@TOM$NavicatDB10832';
        }
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
            $this->pdo->exec("SET time_zone = '+07:00'");
        } catch (\PDOException $e) {
            throw new \PDOException("Database Connection Error: " . $e->getMessage(), (int)$e->getCode());
        }
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->pdo;
    }
}
