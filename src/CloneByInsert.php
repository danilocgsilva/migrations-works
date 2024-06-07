<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks;

use Danilocgsilva\Database\Discover;
use PDO;

class CloneByInsert
{
    public function __construct(private PDO $pdo)
    {
    }

    public function clone(int $id): string
    {
        $discover = new Discover();
        $discover->setPdo($this->pdo);
        $fieldsGenerator = $discover->getFieldsFromTable("users");
        $fieldsString = [];
        /* @var $fieldsGenerator \Danilocgsilva\Database\Field[] */
        foreach ($fieldsGenerator as $field) {
            $fieldsString[] = (string) $field;
        }
        array_shift($fieldsString);
        $fieldsGroups = implode(", ", $fieldsString);

        $entityData = $this->getEntityData($fieldsGroups, $id);

        return 'INSERT INTO users (' . $fieldsGroups . ') VALUES ("' . $entityData[0] . '", "' . $entityData[1] . '", "' . $entityData[2] . '", "' . $entityData[3] . '", "' . $entityData[4]. '");';
    }

    private function getEntityData(string $fieldsGroups, int $id): array
    {
        $getDataQuery = "SELECT " . $fieldsGroups . " FROM users WHERE id = :id;";
        $preResults = $this->pdo->prepare($getDataQuery);
        $preResults->execute([':id' => $id]);
        $preResults->setFetchMode(PDO::FETCH_NUM);
        return $preResults->fetch();
    }
}
