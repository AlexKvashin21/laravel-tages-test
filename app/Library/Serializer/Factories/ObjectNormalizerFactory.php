<?php

namespace App\Library\Serializer\Factories;

use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class ObjectNormalizerFactory extends AbstractObjectNormalizerFactory
{
    protected PropertyAccessorInterface $propertyAccessor;

    /**
     * @param PropertyAccessorInterface $propertyAccessor
     * @return ObjectNormalizerFactory
     */
    public function setPropertyAccessor(PropertyAccessorInterface $propertyAccessor): self
    {
        $this->propertyAccessor = $propertyAccessor;

        return $this;
    }

    /**
     * @return ObjectNormalizer
     */
    public function getNormaliser(): ObjectNormalizer
    {
        return new ObjectNormalizer(
            $this->classMetadataFactory ?? null,
            $this->nameConverter ?? null,
            $this->propertyAccessor ?? null,
            $this->propertyTypeExtractor ?? null,
            $this->classDiscriminatorResolver ?? null,
            $this->objectClassResolver ?? null,
            $this->defaultContext,
        );
    }
}
