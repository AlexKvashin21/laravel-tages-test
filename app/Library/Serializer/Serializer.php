<?php

namespace App\Library\Serializer;

use App\Library\Serializer\Factories\Normalizer;
use App\Library\Serializer\NameConverters\NameConverterHandler;
use Illuminate\Support\Str;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\Serializer\Context\Normalizer\ObjectNormalizerContextBuilder;
use Symfony\Component\Serializer\Encoder\DecoderInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Serializer as BaseSerializer;

class Serializer
{
    /**
     * @param object $dto
     * @param NameConverterInterface|null $nameConverter
     * @param string $format
     * @return string
     */
    public function serialize(object $dto, ?NameConverterInterface $nameConverter = null, string $format = JsonEncoder::FORMAT): string
    {
        $normalizer = new Normalizer();
        $serializer = new BaseSerializer($this->getNormalizers(get_class($dto)), $this->getEncoders(get_class($dto)));
        $context = $normalizer->serializerContextCreate()->withNameConverter($nameConverter)->toArray();

        return $serializer->serialize($dto, $format, context: $context);
    }

    /**
     * @param string $data
     * @param NameConverterInterface|null $nameConverter
     * @param string $dtoClass
     * @param string $format
     * @return object
     */
    public function deserialize(string $data, string $dtoClass, ?NameConverterInterface $nameConverter = null, string $format = JsonEncoder::FORMAT): object
    {
        $normalizer = new Normalizer();
        $serializer = new BaseSerializer($this->getNormalizers($dtoClass), $this->getEncoders($dtoClass));
        $context = $normalizer->serializerContextCreate()->withNameConverter($nameConverter)->toArray();

        return $serializer->deserialize($data, $dtoClass, $format, context: $context);
    }

    /**
     * @param object $dto
     * @param NameConverterInterface|null $nameConverter
     * @return array
     * @throws ExceptionInterface
     */
    public function toArray(object $dto, ?NameConverterInterface $nameConverter = null, ?bool $isSneakKeys = false): array
    {
        $normalizer = new Normalizer();
        $serializer = new BaseSerializer($this->getNormalizers(get_class($dto)));
        $context = $normalizer->serializerContextCreate()->withNameConverter($nameConverter)->toArray();

        $result = $serializer->normalize($dto, context: $context);

        if (!$isSneakKeys) return $result;


        $normalizedKeys = array_map(function ($key) {
            $pieces = preg_split('/(?=[A-Z])/', $key);
            $normalizedPieces = array_map(fn ($piece) => Str::lower($piece), $pieces);
            return implode('_', $normalizedPieces);
        }, array_keys($result));

        return array_combine(
            $normalizedKeys,
            array_values($result)
        );
    }

    /**
     * @template T
     * @param array $data
     * @param class-string<T> $dtoClass
     * @param NameConverterInterface|null $nameConverter
     * @return T|array<T>
     * @throws ExceptionInterface
     */
    public function fromArray(array $data, string $dtoClass, ?NameConverterInterface $nameConverter = null): object|array
    {
        $normalizer = new Normalizer();
        $serializer = new BaseSerializer($this->getNormalizers($dtoClass));
        $context = $normalizer->serializerContextCreate()->withNameConverter($nameConverter)->toArray();

        return $serializer->denormalize($data, $dtoClass, context: $context);
    }

    /**
     * @param string $dtoClass
     * @return array<NormalizerInterface|DenormalizerInterface>
     */
    private function getNormalizers(string $dtoClass): array
    {
        if (method_exists($dtoClass, 'normalizers')) {
            $dtoNormalizers = $dtoClass::normalizers();
        }

        return empty($dtoNormalizers) ? $this->getDefaultNormalizers() : $dtoNormalizers;
    }

    /**
     * @param string $dtoClass
     * @return array<EncoderInterface|DecoderInterface>
     */
    private function getEncoders(string $dtoClass): array
    {
        if (method_exists($dtoClass, 'encoders')) {
            $dtoEncoders = $dtoClass::encoders();
        }

        return empty($dtoEncoders) ? $this->getDefaultEncoders() : $dtoEncoders;
    }

    /**
     * @return array<NormalizerInterface|DenormalizerInterface>
     */
    private function getDefaultNormalizers(): array
    {
        $normalizer = new Normalizer();
        $reflectionExtractor = new ReflectionExtractor();
        $phpDocExtractor = new PhpDocExtractor();
        $propertyTypeExtractor = $normalizer->propertyInfoExtractorCreate()
            ->addListExtractors($reflectionExtractor)
            ->addTypeExtractors($phpDocExtractor)
            ->addTypeExtractors($reflectionExtractor)
            ->addDescriptionExtractors($phpDocExtractor)
            ->addAccessExtractors($reflectionExtractor)
            ->addInitializableExtractors($reflectionExtractor)
            ->getPropertyInfoExtractor();

        $objectNormalizer = $normalizer->objectNormalizerCreate()
            ->setPropertyTypeExtractor($propertyTypeExtractor)
            ->setNameConverter(new NameConverterHandler())
            ->withContext(function (ObjectNormalizerContextBuilder $builder) {
                return $builder->withSkipNullValues(true);
            })
            ->getNormaliser();

        return [
            new ArrayDenormalizer(),
            new DateTimeNormalizer(),
            $objectNormalizer
        ];
    }

    /**
     * @return array<EncoderInterface|DecoderInterface>
     */
    private function getDefaultEncoders(): array
    {
        return [new JsonEncoder()];
    }
}
