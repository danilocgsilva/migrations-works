<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks\Tests;

use PHPUnit\Framework\TestCase;
use Danilocgsilva\MigrationsWorks\UpdateRollback;
use Danilocgsilva\MigrationsWorks\FieldValuePair;
use Danilocgsilva\MigrationsWorks\FowardAndBackwardFieldData;

class UpdateRollbackTest extends TestCase
{
    public function testGetRollbackString(): void
    {
        $fowardAndBackwardFieldData = (new FowardAndBackwardFieldData())
            ->setField("name")
            ->setApplyValue("Robert De Niro")
            ->setRollbackValue("Ashley Kurts")
        ;
        
        $updateRollback = (new UpdateRollback())
            ->setTableName("Customers")
            ->addForwardAndBackwardData($fowardAndBackwardFieldData)
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
        $fowardAndBackwardFieldData = (new FowardAndBackwardFieldData())
            ->setField("name")
            ->setApplyValue("Robert De Niro")
            ->setRollbackValue("Ashley Kurts")
        ;
        
        $updateRollback = (new UpdateRollback())
            ->setTableName("Customers")
            ->addForwardAndBackwardData($fowardAndBackwardFieldData)
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
        $fowardAndBackwardFieldData = (new FowardAndBackwardFieldData())
            ->setField("date_and_hour")
            ->setApplyValue("2024-04-21 15:01:04")
            ->setRollbackValue("2024-03-15 09:42:56")
        ;
        
        $updateRollback = (new UpdateRollback())
            ->setTableName("orders")
            ->addForwardAndBackwardData($fowardAndBackwardFieldData)
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
        $fowardAndBackwardFieldData = (new FowardAndBackwardFieldData())
            ->setField("date_and_hour")
            ->setApplyValue("2024-04-21 15:01:04")
            ->setRollbackValue("2024-03-15 09:42:56")
        ;
        
        $updateRollback = (new UpdateRollback())
            ->setTableName("orders")
            ->addForwardAndBackwardData($fowardAndBackwardFieldData)
            ->setTableIdAndEntityValue(
                (new FieldValuePair())
                    ->setField("id")
                    ->setValue(5543))
        ;

        $expectedString = 'UPDATE orders SET date_and_hour = "2024-04-21 15:01:04" WHERE id = 5543;';

        $this->assertEquals($expectedString, $updateRollback->getApplyMigrationString());
    }
}