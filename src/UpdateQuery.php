<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks;

use Danilocgsilva\MigrationsWorks\QueryAbstract;
use Danilocgsilva\MigrationsWorks\Interfaces\QueryInterface;

class UpdateQuery extends QueryAbstract implements QueryInterface
{
    private array $stringPartsQuery;
    private array $previousData;
    
    public function getRollbackString(): string
    {
        $this->breakStringQuery();

        $previousDataKeys = [];
        foreach ($this->previousData as $key => $value) {
            $previousDataKeys[] = $key;
        }
        
        return 'UPDATE ' . $this->stringPartsQuery[1] . ' SET ' . $previousDataKeys[0] . ' = "' . $this->previousData[$previousDataKeys[0]] . '" WHERE id = ' . $this->stringPartsQuery[9] . ';';
    }

    public function setPrevious(array $previousKeyValue): self
    {
        $this->previousData = $previousKeyValue;
        return $this;
    }

    private function breakStringQuery(): void
    {
        $this->stringPartsQuery = explode(' ', $this->rawQueryText);
        $lastStringPartIndex = count($this->stringPartsQuery) - 1;
        $this->stringPartsQuery[$lastStringPartIndex] = str_replace(';','', $this->stringPartsQuery[$lastStringPartIndex]);
    }
}