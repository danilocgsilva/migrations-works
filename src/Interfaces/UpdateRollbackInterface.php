<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks\Interfaces;

interface UpdateRollbackInterface
{
    public function setTableName(string $tableName): self;

    public function addFieldValuePairBefore(FieldValuePairInterface $fieldValuePair): self;

    public function addFieldValuePairAfter(FieldValuePairInterface $fieldValuePair): self;

    public function setTableIdAndEntityValue(FieldValuePairInterface $fieldValuePair): self;
}