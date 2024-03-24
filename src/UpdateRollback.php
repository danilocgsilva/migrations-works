<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks;
use Danilocgsilva\MigrationsWorks\Interfaces\UpdateRollbackInterface;
use Danilocgsilva\MigrationsWorks\Interfaces\FieldValuePairInterface;
use Danilocgsilva\MigrationsWorks\Interfaces\QueryInterface;

class UpdateRollback implements UpdateRollbackInterface, QueryInterface
{
    private FieldValuePairInterface $fieldValuePairAfter;

    private FieldValuePairInterface $fieldValuePairBefore;

    private FieldValuePairInterface $entityIdAndItsValue;

    private string $tableName;

    private $tableId;
    
    /**
     * @param \Danilocgsilva\MigrationsWorks\Interfaces\FieldValuePairInterface $fieldValuePair
     * @return UpdateRollbackInterface
     */
    public function setFieldValuePairAfter(FieldValuePairInterface $fieldValuePair): UpdateRollbackInterface
    {
        $this->fieldValuePairAfter = $fieldValuePair;
        return $this;
    }
    
    /**
     * @param \Danilocgsilva\MigrationsWorks\Interfaces\FieldValuePairInterface $fieldValuePair
     * @return UpdateRollbackInterface
     */
    public function setFieldValuePairBefore(FieldValuePairInterface $fieldValuePair): UpdateRollbackInterface
    {
        $this->fieldValuePairBefore = $fieldValuePair;
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
            $this->fieldValuePairBefore->getField(),
            $this->fieldValuePairBefore->getValue(),
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
            $this->fieldValuePairAfter->getField(),
            $this->fieldValuePairAfter->getValue(),
            $this->entityIdAndItsValue->getField(),
            $this->entityIdAndItsValue->getValue()
        );
    }
}
