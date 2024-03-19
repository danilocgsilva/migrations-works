<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks\Interfaces;

interface StringDissasemblerInterface
{
    public function getTableName(): string;

    public function getFieldsValuesPairs(): array;

    public function buildWhereRollback(): string;
}
