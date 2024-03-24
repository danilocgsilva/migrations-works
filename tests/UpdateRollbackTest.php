<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks\Tests;

use PHPUnit\Framework\TestCase;
use Danilocgsilva\MigrationsWorks\UpdateRollback;
use Danilocgsilva\MigrationsWorks\FieldValuePair;

class UpdateRollbackTest extends TestCase
{
    public function testGetRollbackString(): void
    {
        $updateRollback = (new UpdateRollback())
            ->setTableName("Customers")
            ->addFieldValuePairBefore(
                (new FieldValuePair())
                    ->setField("name")
                    ->setValue("Ashley Kurts"))
            ->addFieldValuePairAfter(
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
        ->addFieldValuePairBefore(
            (new FieldValuePair())
                ->setField("name")
                ->setValue("Ashley Kurts"))
        ->addFieldValuePairAfter(
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

    public function testGetRollbackString2(): void
    {
        $updateRollback = (new UpdateRollback())
            ->setTableName("orders")
            ->addFieldValuePairBefore(
                (new FieldValuePair())
                    ->setField("date_and_hour")
                    ->setValue("2024-03-15 09:42:56"))
            ->addFieldValuePairAfter(
                (new FieldValuePair())
                    ->setField("date_and_hour")
                    ->setValue("2024-04-21 15:01:04"))
            ->setTableIdAndEntityValue(
                (new FieldValuePair())
                    ->setField("id")
                    ->setValue(5543))
        ;

        $expectedString = 'UPDATE orders SET date_and_hour = "2024-03-15 09:42:56" WHERE id = 5543;';

        $this->assertEquals($expectedString, $updateRollback->getRollbackString());
    }

    public function testGetApplyMigrationString2(): void
    {
        $updateRollback = (new UpdateRollback())
            ->setTableName("orders")
            ->addFieldValuePairBefore(
                (new FieldValuePair())
                    ->setField("date_and_hour")
                    ->setValue("2024-03-15 09:42:56"))
            ->addFieldValuePairAfter(
                (new FieldValuePair())
                    ->setField("date_and_hour")
                    ->setValue("2024-04-21 15:01:04"))
            ->setTableIdAndEntityValue(
                (new FieldValuePair())
                    ->setField("id")
                    ->setValue(5543))
        ;

        $expectedString = 'UPDATE orders SET date_and_hour = "2024-04-21 15:01:04" WHERE id = 5543;';

        $this->assertEquals($expectedString, $updateRollback->getApplyMigrationString());
    }
}