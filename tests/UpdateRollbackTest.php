<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks\Tests;

use Danilocgsilva\MigrationsWorks\StringDissasembler;
use PHPUnit\Framework\TestCase;
use Danilocgsilva\MigrationsWorks\UpdateRollback;
use Danilocgsilva\MigrationsWorks\FieldValuePair;

class UpdateRollbackTest extends TestCase
{
    public function testGetRollbackString(): void
    {
        $updateRollback = (new UpdateRollback())
            ->setTableName("Customers")
            ->setFieldValuePairBefore(
                (new FieldValuePair())
                    ->setField("name")
                    ->setValue("Ashley Kurts"))
            ->setFieldValuePairAfter(
                (new FieldValuePair())
                    ->setField("name")
                    ->setValue("Robert De Niro"))
            ->setTableIdAndEntityValue(
                (new FieldValuePair())
                    ->setField("id")
                    ->setValue(45))
        ;

        $expectedString = 'UPDATE Customers SET name = "Ashley Kurts" WHERE id = 45;';

        $this->assertEquals($expectedString, $updateRollback->getRollbackString());
    }

    public function testGetApplyMigrationString(): void
    {
        $updateRollback = (new UpdateRollback())
        ->setTableName("Customers")
        ->setFieldValuePairBefore(
            (new FieldValuePair())
                ->setField("name")
                ->setValue("Ashley Kurts"))
        ->setFieldValuePairAfter(
            (new FieldValuePair())
                ->setField("name")
                ->setValue("Robert De Niro"))
        ->setTableIdAndEntityValue(
            (new FieldValuePair())
                ->setField("id")
                ->setValue(45))
        ;

        $expectedString = 'UPDATE Customers SET name = "Robert De Niro" WHERE id = 45;';

        $this->assertEquals($expectedString, $updateRollback->getApplyMigrationString());
    }
}