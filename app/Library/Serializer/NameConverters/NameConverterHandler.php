<?php
declare(strict_types=1);

namespace App\Library\Serializer\NameConverters;

use Symfony\Component\Serializer\NameConverter\AdvancedNameConverterInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

class NameConverterHandler implements AdvancedNameConverterInterface
{
    public const CONTEXT_NAME_CONVERTER = 'name_converter';

    /**
     * @param string $propertyName
     * @param string|null $class
     * @param string|null $format
     * @param array $context
     * @return string
     */
    public function normalize(string $propertyName, string $class = null, string $format = null, array $context = []): string
    {
        return $this->getNameConverter($context)?->normalize(...func_get_args()) ?? $propertyName;
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
        return $this->getNameConverter($context)?->denormalize(...func_get_args()) ?? $propertyName;
    }

    /**
     * @param array $context
     * @return NameConverterInterface|null
     */
    protected function getNameConverter(array $context): ?NameConverterInterface
    {
        return $context[self::CONTEXT_NAME_CONVERTER] ?? null;
    }
}
