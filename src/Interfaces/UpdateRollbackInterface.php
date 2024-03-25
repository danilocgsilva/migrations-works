<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks\Interfaces;

interface UpdateRollbackInterface
{
    public function setTableName(string $tableName): self;

    public function addForwardAndBackwardData(FowardAndBackwardFieldDataInterface $fowardAndBackwardFieldDataInterface): self;

    public function setTableIdAndEntityValue(FieldValuePairInterface $fieldValuePair): self;
}