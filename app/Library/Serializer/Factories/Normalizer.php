<?php

namespace App\Library\Serializer\Factories;

class Normalizer
{
    /**
     * @return ObjectNormalizerFactory
     */
    public function objectNormalizerCreate(): ObjectNormalizerFactory
    {
        return new ObjectNormalizerFactory();
    }

    /**
     * @return PropertyInfoExtractorFactory
     */
    public function propertyInfoExtractorCreate(): PropertyInfoExtractorFactory
    {
        return new PropertyInfoExtractorFactory();
    }

    /**
     * @return SerializerContextFactory
     */
    public function serializerContextCreate(): SerializerContextFactory
    {
        return new SerializerContextFactory();
    }
}
