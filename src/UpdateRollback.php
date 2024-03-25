<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks;
use Danilocgsilva\MigrationsWorks\Interfaces\UpdateRollbackInterface;
use Danilocgsilva\MigrationsWorks\Interfaces\FieldValuePairInterface;
use Danilocgsilva\MigrationsWorks\Interfaces\QueryInterface;
use Danilocgsilva\MigrationsWorks\Interfaces\FowardAndBackwardFieldDataInterface;

class UpdateRollback implements UpdateRollbackInterface, QueryInterface
{
    private FowardAndBackwardFieldDataInterface $fowardAndBackwardFieldData;

    private FieldValuePairInterface $entityIdAndItsValue;

    private string $tableName;

    private $tableId;
    
    /**
     * @param \Danilocgsilva\MigrationsWorks\Interfaces\FieldValuePairInterface $fieldValuePair
     * @return UpdateRollbackInterface
     */
    public function addForwardAndBackwardData(FowardAndBackwardFieldDataInterface $fowardAndBackwardFieldData): UpdateRollbackInterface
    {
        $this->fowardAndBackwardFieldData = $fowardAndBackwardFieldData;
        return $this;
    }
    
    /**
     * @param string $tableName
     * @return UpdateRollbackInterface
     */
    public function setTableName(string $tableName): UpdateRollbackInterface
    {
        $this->tableName = $tableName;
        return $this;
    }

    public function setTableIdAndEntityValue(FieldValuePairInterface $fieldValuePair): self
    {
        $this->entityIdAndItsValue = $fieldValuePair;
        return $this;
    }

    /**
     * @return string
     */
    public function getRollbackString(): string
    {
        $baseString = 'UPDATE %s SET %s = "%s" WHERE %s = %s;';
        return sprintf(
            $baseString,
            $this->tableName,
            $this->fowardAndBackwardFieldData->getField(),
            $this->fowardAndBackwardFieldData->getRollbackValue(),
            $this->entityIdAndItsValue->getField(),
            $this->entityIdAndItsValue->getValue()
        );
    }

    public function getApplyMigrationString(): string
    {
        $baseString = 'UPDATE %s SET %s = "%s" WHERE %s = %s;';
        return sprintf(
            $baseString,
            $this->tableName,
            $this->fowardAndBackwardFieldData->getField(),
            $this->fowardAndBackwardFieldData->getApplyValue(),
            $this->entityIdAndItsValue->getField(),
            $this->entityIdAndItsValue->getValue()
        );
    }
}
