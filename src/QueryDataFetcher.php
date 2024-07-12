<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks;

use PDO;
use Danilocgsilva\Database\Discover;

class QueryDataFetcher
{
    private array $fieldsNames = [];
    
    public function __construct(private PDO $pdo) {}

    public function getFieldNamesTable(string $tableName): array
    {
        $fieldsGenerator = (new Discover($this->pdo))->getFieldsFromTable($tableName);
        foreach ($fieldsGenerator as $tableField) {
            $this->fieldsNames[] = (string) $tableField;
        }
        return $this->fieldsNames;
    }
    
    public function getValuesBasedOnId(string $tableName, array $rowFieldsNamesRaw, string $idValue)
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
            $fields[] = $rowData;
        }

        return $fields;
    }

    private function getKeyFieldName(): string
    {
        return $this->fieldsNames[0];
    }
}
