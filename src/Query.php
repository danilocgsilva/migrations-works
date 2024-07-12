<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks;

use Danilocgsilva\MigrationsWorks\Interfaces\QueryInterface;
use Danilocgsilva\MigrationsWorks\StringDissasembler;
use Danilocgsilva\MigrationsWorks\StringDisassemblerMultiples;
use PDO;

class Query extends QueryAbstract implements QueryInterface
{
    private array $keysToDisable = [];

    public function addKeyToDisable(string $key): self
    {
        $this->keysToDisable[] = $key;
        return $this;
    }

    public function getRollbackString(): string
    {
        $stringDisassemblerMultiples = new StringDisassemblerMultiples($this->rawQueryText);
        $lines = [];
        foreach ($stringDisassemblerMultiples->queriesDetected() as $querySingle) {
            $stringDissassembler = (new StringDissasembler($querySingle))
            ->setIgnoreKeys($this->keysToDisable);
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

    public function extractInsert(
        string $idValue, 
        string $tableName, 
        bool $ignore = true,
        PDO $pdo
    ): string
    {
        $queryDataFetcher = new QueryDataFetcher($pdo);
        
        $queryInsert = sprintf(
            $ignore ? "INSERT IGNORE INTO %s (%s) VALUES (%s);" : "INSERT INTO %s (%s) VALUES (%s);", 
            $tableName, 
            implode(", ", ($rowFieldsNamesRaw = $queryDataFetcher->getFieldNamesTable($tableName))), 
            implode(", ", $queryDataFetcher->getValuesBasedOnId($tableName, $rowFieldsNamesRaw, $idValue))
        );

        return $queryInsert;
    }
}
