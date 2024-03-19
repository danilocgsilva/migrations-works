<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks\Interfaces;

interface QueryInterface
{
    public function getRollbackString(): string;
}

