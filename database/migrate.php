<?php

declare(strict_types=1);

use Dotenv\Dotenv;
use PDO;

$rootPath = dirname(__DIR__);
require $rootPath . '/vendor/autoload.php';

Dotenv::createImmutable($rootPath)->safeLoad();

$host = $_ENV['DB_HOST'] ?? '127.0.0.1';
$port = (int) ($_ENV['DB_PORT'] ?? 3306);
$database = $_ENV['DB_DATABASE'] ?? '';
$username = $_ENV['DB_USERNAME'] ?? '';
$password = $_ENV['DB_PASSWORD'] ?? '';

if ($database === '' || $username === '') {
    fwrite(STDERR, "Database configuration is incomplete.\n");
    exit(1);
}

$pdo = new PDO(
    "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4",
    $username,
    $password,
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]
);

$pdo->exec('CREATE TABLE IF NOT EXISTS schema_migrations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    filename VARCHAR(255) NOT NULL UNIQUE,
    checksum CHAR(64) NOT NULL,
    applied_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');

$applied = $pdo->query('SELECT filename, checksum FROM schema_migrations')->fetchAll(PDO::FETCH_KEY_PAIR);
$migrationFiles = glob(__DIR__ . '/migrations/*.sql') ?: [];
sort($migrationFiles, SORT_NATURAL);

foreach ($migrationFiles as $migrationFile) {
    $filename = basename($migrationFile);
    $sql = file_get_contents($migrationFile);
    $checksum = hash('sha256', $sql);

    if (isset($applied[$filename])) {
        if (!hash_equals($applied[$filename], $checksum)) {
            throw new RuntimeException("Migration checksum mismatch: {$filename}");
        }
        continue;
    }

    try {
        // MySQL DDL commits implicitly, so migrations are tracked only after execution succeeds.
        $pdo->exec($sql);
        $statement = $pdo->prepare('INSERT INTO schema_migrations (filename, checksum) VALUES (?, ?)');
        $statement->execute([$filename, $checksum]);
        echo "Applied {$filename}\n";
    } catch (Throwable $exception) {
        throw $exception;
    }
}

echo "Migrations are up to date.\n";
