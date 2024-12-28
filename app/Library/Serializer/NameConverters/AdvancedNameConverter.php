<?php

declare(strict_types=1);

namespace App\Library\Serializer\NameConverters;

use Illuminate\Support\Arr;
use Symfony\Component\Serializer\NameConverter\AdvancedNameConverterInterface;

abstract class AdvancedNameConverter implements AdvancedNameConverterInterface
{
    /**
     * key - name class
     * key.key - name in dto
     * key.value - name array
     * @return array
     */
    abstract protected function map(): array;

    /**
     * @param string $propertyName
     * @param string|null $class
     * @param string|null $format
     * @param array $context
     * @return string
     */
    public function normalize(string $propertyName, string $class = null, string $format = null, array $context = []): string
    {
        return Arr::get($this->map(), "$class.$propertyName", $propertyName);
    }

    /**
     * @param string $propertyName
     * @param string|null $class
     * @param string|null $format
     * @param array $context
     * @return string
     */
    public function denormalize(string $propertyName, string $class = null, string $format = null, array $context = []): string
    {
        return Arr::get(array_flip($this->map()[$class] ?? []), $propertyName, $propertyName);
    }
}
