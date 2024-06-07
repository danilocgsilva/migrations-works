<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks\Tests\Integration;

use Danilocgsilva\MigrationsWorks\CloneByInsert;
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
        $preResults = $pdo->prepare($queryGenerating);
        $preResults->execute();

        $cloneByInsert = new CloneByInsert($pdo);
        $queryInsert = $cloneByInsert->clone(1);
        $expectedString = $queryGenerating = 'INSERT INTO users (name, username, password, email, profile) VALUES ("John Tonias", "jtonias", "john56756_lola@test.com", "John John");';
        $this->assertSame($expectedString, $queryInsert);
    }
}
