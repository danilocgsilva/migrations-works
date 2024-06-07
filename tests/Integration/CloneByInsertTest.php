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

        
    }
}
