<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks\Interfaces;

interface UpdateRollbackInterface
{
    public function setTableName(string $tableName): self;

    public function setFieldValuePairBefore(FieldValuePairInterface $fieldValuePair): self;

    public function setFieldValuePairAfter(FieldValuePairInterface $fieldValuePair): self;

    public function setTableIdAndEntityValue(FieldValuePairInterface $fieldValuePair): self;
}