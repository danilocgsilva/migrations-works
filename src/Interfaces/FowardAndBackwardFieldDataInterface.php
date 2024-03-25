<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks\Interfaces;

interface FowardAndBackwardFieldDataInterface
{
    public function getField(): string;

    public function setField(string $field): self;

    public function setRollbackValue($value): self;
    
    public function setApplyValue($value): self;

    public function getRollbackValue();

    public function getApplyValue();
}