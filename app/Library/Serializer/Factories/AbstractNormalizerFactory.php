<?php

namespace App\Library\Serializer\Factories;

use Symfony\Component\Serializer\Mapping\Factory\ClassMetadataFactoryInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

abstract class AbstractNormalizerFactory
{
    protected ClassMetadataFactoryInterface $classMetadataFactory;
    protected NameConverterInterface $nameConverter;
    protected array $defaultContext = [];

    /**
     * @param ClassMetadataFactoryInterface $classMetadataFactory
     * @return AbstractNormalizerFactory
     */
    public function setClassMetadataFactory(ClassMetadataFactoryInterface $classMetadataFactory): self
    {
        $this->classMetadataFactory = $classMetadataFactory;

        return $this;
    }

    /**
     * @param NameConverterInterface $nameConverter
     * @return AbstractNormalizerFactory
     */
    public function setNameConverter(NameConverterInterface $nameConverter): self
    {
        $this->nameConverter = $nameConverter;

        return $this;
    }

    /**
     * @param array $defaultContext
     * @return AbstractNormalizerFactory
     */
    public function setDefaultContext(array $defaultContext): self
    {
        $this->defaultContext = $defaultContext;

        return $this;
    }

    /**
     * @return NormalizerInterface
     */
    abstract public function getNormaliser(): NormalizerInterface;
}
