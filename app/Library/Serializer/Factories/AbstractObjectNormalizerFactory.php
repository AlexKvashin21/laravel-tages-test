<?php

namespace App\Library\Serializer\Factories;

use Closure;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\Mapping\ClassDiscriminatorResolverInterface;

abstract class AbstractObjectNormalizerFactory extends AbstractNormalizerFactory
{
    protected PropertyTypeExtractorInterface $propertyTypeExtractor;
    protected ClassDiscriminatorResolverInterface $classDiscriminatorResolver;
    protected Closure $objectClassResolver;

    /**
     * @param PropertyTypeExtractorInterface $propertyTypeExtractor
     * @return AbstractObjectNormalizerFactory
     */
    public function setPropertyTypeExtractor(PropertyTypeExtractorInterface $propertyTypeExtractor): self
    {
        $this->propertyTypeExtractor = $propertyTypeExtractor;

        return $this;
    }

    /**
     * @param ClassDiscriminatorResolverInterface $classDiscriminatorResolver
     * @return AbstractObjectNormalizerFactory
     */
    public function setClassDiscriminatorResolver(ClassDiscriminatorResolverInterface $classDiscriminatorResolver): self
    {
        $this->classDiscriminatorResolver = $classDiscriminatorResolver;

        return $this;
    }

    /**
     * @param callable $objectClassResolver
     * @return AbstractObjectNormalizerFactory
     */
    public function setObjectClassResolver(callable $objectClassResolver): self
    {
        $this->objectClassResolver = $objectClassResolver;

        return $this;
    }

    /**
     * @param callable(ObjectNormalizerContextBuilder):ObjectNormalizerContextBuilder $callable
     * @return $this
     */
    public function withContext(callable $callable): self
    {
        $this->setDefaultContext($callable(new ObjectNormalizerContextBuilder())->toArray());

        return $this;
    }
}
