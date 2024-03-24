<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks\Interfaces;

interface FieldValuePairInterface
{
    public function getField(): string;

    public function setField(string $field): self;

    public function getValue();

    public function setValue($value): self;
}
