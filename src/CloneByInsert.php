<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks;

use PDO;

class CloneByInsert
{
    public function __construct(private PDO $pdo)
    {
    }

    public function clone(int $id)
    {
        
    }
}
