<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks\Tests\Integration;

use PHPUnit\Framework\TestCase;
use PDO;

class CloneByInsertTest extends TestCase
{
    public function testCloneByInsert(): void
    {
        $pdo = new PDO(
            sprintf('mysql:host=%s;dbname=migrations_works_tests', getenv('MIGRATIONS_WORKS_TEST_DB_HOST')),
            getenv('MIGRATIONS_WORKS_TEST_DB_USER'), 
            getenv('MIGRATIONS_WORKS_TEST_DB_PASSWORD')
        );
        
        $createDatase = <<<EOF
CREATE DATABASE migrations_works_tests (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    profile VARCHAR(255) NOT NULL
) ENGINE=InnoDb CHARSET=utf8mb3 COLLATE=uft8mb3_general_ci
EOF;
    }
}
