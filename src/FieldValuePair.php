<?php

declare(strict_types=1);

namespace Danilocgsilva\MigrationsWorks;

use Danilocgsilva\MigrationsWorks\Interfaces\FieldValuePairInterface;

class FieldValuePair implements FieldValuePairInterface
{
    private string $field;

    private $value;

    /**
     * @return string
     */
    function getField(): string
    {
        return $this->field;
    }
    
    /**
     */
    function getValue()
    {
        return $this->value;
    }
    
    /**
     *
     * @param string $field
     * @return FieldValuePairInterface
     */
    function setField(string $field): FieldValuePairInterface
    {
        $this->field = $field;
        return $this;
    }
    
    /**
     *
     * @param mixed $value
     * @return FieldValuePairInterface
     */
    function setValue($value): FieldValuePairInterface
    {
        $this->value = $value;
        return $this;
    }
}
