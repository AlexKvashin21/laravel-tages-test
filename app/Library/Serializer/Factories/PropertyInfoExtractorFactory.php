<?php

namespace App\Library\Serializer\Factories;

use Symfony\Component\PropertyInfo\PropertyAccessExtractorInterface;
use Symfony\Component\PropertyInfo\PropertyDescriptionExtractorInterface;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\PropertyInfo\PropertyInitializableExtractorInterface;
use Symfony\Component\PropertyInfo\PropertyListExtractorInterface;
use Symfony\Component\PropertyInfo\PropertyTypeExtractorInterface;

class PropertyInfoExtractorFactory
{
    private array $listExtractors = [];
    private array $typeExtractors = [];
    private array $descriptionExtractors = [];
    private array $accessExtractors = [];
    private array $initializableExtractors = [];

    /**
     * @param PropertyListExtractorInterface $listExtractor
     * @return PropertyInfoExtractorFactory
     */
    public function addListExtractors(PropertyListExtractorInterface $listExtractor): self
    {
        $this->listExtractors[] = $listExtractor;

        return $this;
    }

    /**
     * @param PropertyTypeExtractorInterface $typeExtractor
     * @return PropertyInfoExtractorFactory
     */
    public function addTypeExtractors(PropertyTypeExtractorInterface $typeExtractor): self
    {
        $this->typeExtractors[] = $typeExtractor;

        return $this;
    }

    /**
     * @param PropertyDescriptionExtractorInterface $descriptionExtractor
     * @return PropertyInfoExtractorFactory
     */
    public function addDescriptionExtractors(PropertyDescriptionExtractorInterface $descriptionExtractor): self
    {
        $this->descriptionExtractors[] = $descriptionExtractor;

        return $this;
    }

    /**
     * @param PropertyAccessExtractorInterface $accessExtractor
     * @return PropertyInfoExtractorFactory
     */
    public function addAccessExtractors(PropertyAccessExtractorInterface $accessExtractor): self
    {
        $this->accessExtractors[] = $accessExtractor;

        return $this;
    }

    /**
     * @param PropertyInitializableExtractorInterface $initializableExtractor
     * @return PropertyInfoExtractorFactory
     */
    public function addInitializableExtractors(PropertyInitializableExtractorInterface $initializableExtractor): self
    {
        $this->initializableExtractors[] = $initializableExtractor;

        return $this;
    }

    /**
     * @return PropertyInfoExtractor
     */
    public function getPropertyInfoExtractor(): PropertyInfoExtractor
    {
        return new PropertyInfoExtractor(
            $this->listExtractors,
            $this->typeExtractors,
            $this->descriptionExtractors,
            $this->accessExtractors,
            $this->initializableExtractors,
        );
    }
}
