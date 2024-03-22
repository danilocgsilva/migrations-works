<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks;

use Danilocgsilva\MigrationsWorks\Interfaces\StringDisassemblerMultiplesInterface;

class StringDisassemblerMultiples extends QueryAbstract implements StringDisassemblerMultiplesInterface
{
    public function queriesDetected(): array
    {
        $rawExploded = explode(";", $this->rawQueryText);
        if (end($rawExploded) === "") {
            array_pop($rawExploded);
        }

        return array_map(fn ($entry) => $entry . ";", $rawExploded);
    }
}
