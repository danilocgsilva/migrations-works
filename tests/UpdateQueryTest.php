<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks\Tests;

use PHPUnit\Framework\TestCase;
use Danilocgsilva\MigrationsWorks\UpdateQuery;

class UpdateQueryTest extends TestCase
{
    public function testGetRollbackString()
    {
        $query = "UPDATE payment SET payment_value = 12.55 WHERE id = 545;";
        $updateQueryObj = new UpdateQuery($query);
        $updateQueryObj->setPrevious(['payment_value' => 11.02]);
        $rollbackQuery = 'UPDATE payment SET payment_value = "11.02" WHERE id = 545;';
        $this->assertSame($rollbackQuery, $updateQueryObj->getRollbackString());
    }

    public function testGetRollbackString2()
    {
        $query = 'UPDATE people SET birthdate = "1994-05-22" WHERE id = 43;';
        $updateQueryObj = new UpdateQuery($query);
        $updateQueryObj->setPrevious(['birthdate' => '1995-06-15']);
        $rollbackQuery = 'UPDATE people SET birthdate = "1995-06-15" WHERE id = 43;';
        $this->assertSame($rollbackQuery, $updateQueryObj->getRollbackString());
    }
}
