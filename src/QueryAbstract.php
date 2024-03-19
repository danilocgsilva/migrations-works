<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks;

abstract class QueryAbstract
{
    public function __construct(protected string $rawQueryText) {}
}