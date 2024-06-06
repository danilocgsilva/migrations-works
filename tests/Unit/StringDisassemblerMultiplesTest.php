<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Danilocgsilva\MigrationsWorks\StringDisassemblerMultiples;

class StringDisassemblerMultiplesTest extends TestCase
{
    public function testQueriesDetected(): void
    {
        $queryStrings = [
            'INSERT INTO people (id, name, age, height, weight) VALUES (11, "Erika", 18, NULL, 66);',
            'INSERT INTO people (id, name, age, height, weight) VALUES (12, "Lucas", 22, NULL, 88);'
        ];

        $queryString = implode("", $queryStrings);

        $stringDisassemblerMultiples = new StringDisassemblerMultiples($queryString);
        
        foreach ($stringDisassemblerMultiples->queriesDetected() as $key => $value) {
            $this->assertSame($queryStrings[$key], $value);
        }
    }
}