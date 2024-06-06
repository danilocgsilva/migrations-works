<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Danilocgsilva\MigrationsWorks\Query;

class QueryTest extends TestCase
{
    public function testRollbackQuery1(): void
    {
        $queryString = 'INSERT INTO drivers (id, car, name) VALUES (12, 3, "John Tonias");';
        $query = new Query($queryString);

        $expectedRollbackString = 'DELETE FROM drivers WHERE id = 12 AND car = 3 AND name = "John Tonias";';

        $this->assertSame(
            $expectedRollbackString,
            $query->getRollbackString()
        );
    }

    public function testRollbackQuery2(): void
    {
        $queryString = 'INSERT INTO people (id, name, age, height, weight) VALUES (11, "Erika", 18, 1.78, 66);';
        $query = new Query($queryString);
        $expectedRollbackString = 'DELETE FROM people WHERE id = 11 AND name = "Erika" AND age = 18 AND height = 1.78 AND weight = 66;';

        $this->assertSame(
            $expectedRollbackString,
            $query->getRollbackString()
        );
    }

    public function testRollbackQueryWithNull(): void
    {
        $queryString = 'INSERT INTO people (id, name, age, height, weight) VALUES (11, "Erika", 18, NULL, 66);';
        $query = new Query($queryString);
        $expectedRollbackString = 'DELETE FROM people WHERE id = 11 AND name = "Erika" AND age = 18 AND height IS NULL AND weight = 66;';

        $this->assertSame(
            $expectedRollbackString,
            $query->getRollbackString()
        );
    }

    public function testRollbackQueryWithDatabase(): void
    {
        $queryString = 'INSERT INTO mydatabase.people (id, name, age, height, weight) VALUES (11, "Erika", 18, NULL, 66);';
        $query = new Query($queryString);
        $expectedRollbackString = 'DELETE FROM mydatabase.people WHERE id = 11 AND name = "Erika" AND age = 18 AND height IS NULL AND weight = 66;';

        $this->assertSame(
            $expectedRollbackString,
            $query->getRollbackString()
        );
    }

    public function testRollbackQueryMultipleLines(): void
    {
        $queryString = 'INSERT INTO people (id, name, age, height, weight) VALUES (11, "Erika", 18, NULL, 66);';
        $queryString .= 'INSERT INTO people (id, name, age, height, weight) VALUES (12, "Lucas", 22, NULL, 88);';

        $query = new Query($queryString);
        $expectedRollbackString = 'DELETE FROM people WHERE id = 11 AND name = "Erika" AND age = 18 AND height IS NULL AND weight = 66;DELETE FROM people WHERE id = 12 AND name = "Lucas" AND age = 22 AND height IS NULL AND weight = 88;';

        $this->assertSame(
            $expectedRollbackString,
            $query->getRollbackString()
        );
    }

    public function testAddKeyToDisable()
    {
        $queryString = 'INSERT INTO people (id, name, age, height, weight) VALUES (11, "Erika", 18, 1.78, 66);';
        $query = new Query($queryString);
        $query->addKeyToDisable('height');
        $expectedRollbackString = 'DELETE FROM people WHERE id = 11 AND name = "Erika" AND age = 18 AND weight = 66;';

        $this->assertSame(
            $expectedRollbackString,
            $query->getRollbackString()
        );
    }
}

