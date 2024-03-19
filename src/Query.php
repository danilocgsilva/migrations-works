<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks;

use Danilocgsilva\MigrationsWorks\Interfaces\QueryInterface;
use Danilocgsilva\MigrationsWorks\StringDissasembler;

class Query implements QueryInterface
{
    public function __construct(private string $rawQueryText) {}
    
    public function getRollbackString(): string
    {
        $stringDissassembler = new StringDissasembler($this->rawQueryText);

        $tablePart = $stringDissassembler->getTableName();

        $wherePart = $stringDissassembler->buildWhereRollback();
        
        return 'DELETE FROM ' . $tablePart . ' ' . $wherePart . ';';
    }
}

