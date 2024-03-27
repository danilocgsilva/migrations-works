<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks;

use Danilocgsilva\MigrationsWorks\Interfaces\StringDissasemblerInterface;

class StringDissasembler extends QueryAbstract implements StringDissasemblerInterface
{
    private array $ignoreKeys = [];
    
    public function getTableName(): string
    {
        $queryTerms = explode(" ", $this->rawQueryText);
        
        return $queryTerms[2];
    }

    public function setIgnoreKeys(array $keys): self
    {
        $this->ignoreKeys = $keys;
        return $this;
    }

    public function getFieldsValuesPairs(): array
    {
        $stringParts = preg_split('/(\(|\))/', $this->rawQueryText);
        
        $fieldsPart = $stringParts[1];
        $valuesParts = $stringParts[3];

        $fields = explode(",", $fieldsPart);
        $values = explode(",", $valuesParts);

        $fieldsPaddingClean = array_map(fn ($entry) => trim($entry, ' '), $fields);
        $valuesPaddingClean = array_map(fn ($entry) => trim($entry, ' '), $values);

        $pairs = [];
        foreach ($fieldsPaddingClean as $key => $field) {
            $pairs[$field] = $valuesPaddingClean[$key];
        }

        return $pairs;
    }

    public function buildWhereRollback(): string
    {
        $pairs = $this->getFieldsValuesPairs();

        $whereString = "";
        foreach ($pairs as $key => $pair) {

            if (in_array($key, $this->ignoreKeys)) {
                continue;
            }
            
            if ($pair === reset($pairs)) {
                $whereString .= "WHERE ";
            } else {
                $whereString .= " AND ";
            }

            if ($pair === "NULL") {
                $whereString .=  $key . " IS " . $pair;
            } else {
                $whereString .=  $key . " = " . $pair;
            }
        }

        return $whereString;
    }
}

