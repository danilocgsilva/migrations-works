<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks;

use PDO;
use Danilocgsilva\Database\Discover;

class QueryDataFetcher
{
    private array $fieldsNames = [];
    
    public function __construct(private PDO $pdo) {}

    public function extractInsert(
        string $idValue, 
        string $tableName, 
        bool $ignore = true
    ): string
    {
        $queryDataFetcher = new QueryDataFetcher($this->pdo);
        
        $insertValuesString = implode(", ", ($rowFieldsNamesRaw = $queryDataFetcher->getFieldNamesTable($tableName)));


        $queryInsert = sprintf(
            $ignore ? "INSERT IGNORE INTO %s (%s) VALUES (%s);" : "INSERT INTO %s (%s) VALUES (%s);", 
            $tableName, 
            $insertValuesString, 
            $this->convertSuitableStringValues(
                $queryDataFetcher->getValuesBasedOnId($tableName, $rowFieldsNamesRaw, $idValue)
            )
        );
        return $queryInsert;
    }

    public function getFieldNamesTable(string $tableName): array
    {
        $fieldsGenerator = (new Discover($this->pdo))->getFieldsFromTable($tableName);
        foreach ($fieldsGenerator as $tableField) {
            $this->fieldsNames[] = (string) $tableField;
        }

        return $this->fieldsNames;
    }
    
    public function getValuesBasedOnId(string $tableName, array $rowFieldsNamesRaw, string $idValue): array
    {
        $queryFetching = sprintf(
            "SELECT %s FROM %s WHERE %s = :idValue;",
            implode(", ", $rowFieldsNamesRaw),
            $tableName,
            $this->getKeyFieldName()
        );

        $preResults = $this->pdo->prepare($queryFetching);
        $preResults->setFetchMode(PDO::FETCH_NUM);
        $preResults->execute([':idValue' => $idValue]);

        $rowData = $preResults->fetch();
        $fields = [];
        foreach ($rowData as $fieldDataValue) {
            $fields[] = $fieldDataValue;
        }

        return $fields;
    }

    private function getKeyFieldName(): string
    {
        return $this->fieldsNames[0];
    }

    private function convertSuitableStringValues($rawFieldsValueData)
    {
        $suitableValues = [];
        foreach ($rawFieldsValueData as $rawValue) {
            if ($rawValue === null) {
                $suitableValues[] = "NULL";
            } elseif (is_string($rawValue)) {
                if (preg_match('/\"/', $rawValue)) {
                    $suitableValues[] = sprintf("%s%s%s", "'", $rawValue, "'");
                } else {
                    $suitableValues[] = sprintf("%s%s%s", "\"", $rawValue, "\"");
                }
            } else {
                $suitableValues[] = $rawValue;
            }
        }
        return implode(", ", $suitableValues);
    }
}
