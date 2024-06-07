<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks\Tests\Integration;

use Danilocgsilva\MigrationsWorks\CloneByInsert;
use PHPUnit\Framework\TestCase;
use PDO;

class CloneByInsertTest extends TestCase
{
    private PDO $pdo;

    public function setUp(): void
    {
        $this->pdo = new PDO(
            sprintf('mysql:host=%s;dbname=migrations_works_tests', getenv('MIGRATIONS_WORKS_TEST_DB_HOST')),
            getenv('MIGRATIONS_WORKS_TEST_DB_USER'),
            getenv('MIGRATIONS_WORKS_TEST_DB_PASSWORD')
        );
    }

    public function testCloneByInsert(): void
    {
        $this->eraseTable();

        $queryGenerating = <<<EOF
INSERT INTO users (
    name,
    username,
    password,
    email,
    profile
) VALUES (
    "John Tonias",
    "jtonias",
    "mystrongpassword",
    "john56756_lola@test.com",
    "John John"
);
EOF;
        $this->fillTestData($queryGenerating);

        $cloneByInsert = new CloneByInsert($this->pdo);
        $queryInsert = $cloneByInsert->clone(1);
        $expectedString = $queryGenerating = 'INSERT INTO users (name, username, password, email, profile) VALUES ("John Tonias", "jtonias", "mystrongpassword", "john56756_lola@test.com", "John John");';
        $this->assertSame($expectedString, $queryInsert);
    }

    public function test2CloneByInsert(): void
    {
        $this->eraseTable();

        $queryGenerating = <<<EOF
INSERT INTO users (
    name,
    username,
    password,
    email,
    profile
) VALUES (
    "Helena",
    "helNa",
    "anotherverystrongpassword",
    "helenasas@test.com",
    "Helga the Viking"
);
EOF;

        $this->fillTestData($queryGenerating);

        $cloneByInsert = new CloneByInsert($this->pdo);
        $queryInsert = $cloneByInsert->clone(1);
        $expectedString = $queryGenerating = 'INSERT INTO users (name, username, password, email, profile) VALUES ("Helena", "helNa", "anotherverystrongpassword", "helenasas@test.com", "Helga the Viking");';
        $this->assertSame($expectedString, $queryInsert);
    }

    public function test3CloneByInsert(): void
    {
        $this->eraseTable();

        $queryGenerating = <<<EOF
INSERT INTO payment (
    process_code,
    part_name,
    payment_method
) VALUES (
    "0001232",
    "Robert Anthony",
    "Credit Card",
);
EOF;
        $this->fillTestData($queryGenerating);

        $cloneByInsert = new CloneByInsert($this->pdo);
        $queryInsert = $cloneByInsert->clone(1);
        $expectedString = $queryGenerating = 'INSERT INTO payment (process_code, part_name, payment_method) VALUES ("0001232", "Robert Anthony", "Credit Card");';
        $this->assertSame($expectedString, $queryInsert);
    }

    private function fillTestData(string $query)
    {
        $preResults = $this->pdo->prepare($query);
        $preResults->execute();
    }

    private function eraseTable(): void
    {
        $queryDelete = "DELETE FROM users; ALTER TABLE users AUTO_INCREMENT = 1";
        $preResults = $this->pdo->prepare($queryDelete);
        $preResults->execute();
    }
}
