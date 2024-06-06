<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks\Tests\Unit;

use Danilocgsilva\MigrationsWorks\StringDissasembler;
use PHPUnit\Framework\TestCase;

class StringDissasemblerTest extends TestCase
{
    public function testTableNameQuery1()
    {
        $queryString = 'INSERT INTO drivers (id, car, name) VALUES (12, 3, "John Tonias");';
        $stringDissasember = new StringDissasembler($queryString);
        $expectedString = "drivers";
        $this->assertSame($expectedString, $stringDissasember->getTableName());
    }

    public function testTableNameQuery2()
    {
        $queryString = 'INSERT INTO people (id, name, age, height, weight) VALUES (11, "Erika", 18, 1.78, 66);';
        $stringDissasember = new StringDissasembler($queryString);
        $expectedString = "people";
        $this->assertSame($expectedString, $stringDissasember->getTableName());
    }

    public function testGetFieldsValuesPairs1()
    {
        $queryString = 'INSERT INTO drivers (id, car, name) VALUES (12, 3, "John Tonias");';
        $stringDissasember = new StringDissasembler($queryString);
        $expectedArray = [
            'id' => "12",
            'car' => "3",
            'name' => '"John Tonias"'
        ];
        $returnedArray = $stringDissasember->getFieldsValuesPairs();
        foreach ($expectedArray as $key => $value) {
            $this->assertSame($returnedArray[$key], $value);
        }
    }

    public function testGetFieldsValuesPairs2()
    {
        $queryString = 'INSERT INTO people (id, name, age, height, weight) VALUES (11, "Erika", 18, 1.78, 66);';
        $stringDissasember = new StringDissasembler($queryString);
        $expectedArray = [
            'id' => "11",
            'name' => '"Erika"',
            'age' => "18",
            'height' => "1.78",
            'weight' => "66"
        ];
        $returnedArray = $stringDissasember->getFieldsValuesPairs();
        foreach ($expectedArray as $key => $value) {
            $this->assertSame($returnedArray[$key], $value);
        }
    }

    public function testBuildWhereRollback1()
    {
        $queryString = 'INSERT INTO drivers (id, car, name) VALUES (12, 3, "John Tonias");';
        $stringDissasember = new StringDissasembler($queryString);
        $expectedWherePartString = 'WHERE id = 12 AND car = 3 AND name = "John Tonias"';
        $this->assertSame(
            $expectedWherePartString,
            $stringDissasember->buildWhereRollback()
        );
    }

    public function testBuildWhereRollback2()
    {
        $queryString = 'INSERT INTO people (id, name, age, height, weight) VALUES (11, "Erika", 18, 1.78, 66);';
        $stringDissasember = new StringDissasembler($queryString);
        $expectedWherePartString = 'WHERE id = 11 AND name = "Erika" AND age = 18 AND height = 1.78 AND weight = 66';
        $this->assertSame(
            $expectedWherePartString,
            $stringDissasember->buildWhereRollback()
        );
    }
}