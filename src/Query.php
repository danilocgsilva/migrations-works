<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks;

use Danilocgsilva\MigrationsWorks\Interfaces\QueryInterface;
use Danilocgsilva\MigrationsWorks\StringDissasembler;
use Danilocgsilva\MigrationsWorks\StringDisassemblerMultiples;

class Query extends QueryAbstract implements QueryInterface
{
    public function getRollbackString(): string
    {
        $stringDisassemblerMultiples = new StringDisassemblerMultiples($this->rawQueryText);

        $lines = [];
        foreach ($stringDisassemblerMultiples->queriesDetected() as $querySingle) {
            $stringDissassembler = new StringDissasembler($querySingle);
            $tablePart = $stringDissassembler->getTableName();
            $wherePart = $stringDissassembler->buildWhereRollback();
            $lines[] = 'DELETE FROM ' . $tablePart . ' ' . $wherePart . ';';
        }

        $queryRollback = "";

        foreach ($lines as $line) {
            $queryRollback .= $line;
        }

        return $queryRollback;
    }
}
