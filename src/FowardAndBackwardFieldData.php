<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks;

use Danilocgsilva\MigrationsWorks\Interfaces\FowardAndBackwardFieldDataInterface;

class FowardAndBackwardFieldData implements FowardAndBackwardFieldDataInterface
{
    private string $field;

    private $rollbackValue;

    private $applyValue;

    public function setField(string $field): self
    {
        $this->field = $field;
        return $this;
    }
    
    public function getField(): string
    {
        return $this->field;
    }

    public function setRollbackValue($value): self
    {
        $this->rollbackValue = $value;
        return $this;
    }
    
    public function setApplyValue($value): self
    {
        $this->applyValue = $value;
        return $this;
    }

    public function getRollbackValue()
    {
        return $this->rollbackValue;
    }

    public function getApplyValue()
    {
        return $this->applyValue;
    }
}
