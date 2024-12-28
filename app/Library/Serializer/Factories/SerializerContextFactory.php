<?php

namespace App\Library\Serializer\Factories;

use App\Library\Serializer\NameConverters\NameConverterHandler;
use BadMethodCallException;
use Symfony\Component\Serializer\Context\ContextBuilderInterface;
use Symfony\Component\Serializer\Context\ContextBuilderTrait;
use Symfony\Component\Serializer\Context\SerializerContextBuilder;
use Symfony\Component\Serializer\NameConverter\NameConverterInterface;

/**
 * @mixin SerializerContextBuilder
 */
class SerializerContextFactory implements ContextBuilderInterface
{
    private SerializerContextBuilder $contextBuilder;

    use ContextBuilderTrait;

    /**
     */
    public function __construct()
    {
        $this->contextBuilder = new SerializerContextBuilder();
    }

    /**
     * @param NameConverterInterface|null $nameConverter
     * @return $this
     */
    public function withNameConverter(?NameConverterInterface $nameConverter): static
    {
        return $this->with(NameConverterHandler::CONTEXT_NAME_CONVERTER, $nameConverter);
    }

    /**
     * @param $method
     * @param $parameters
     * @return $this
     */
    public function __call($method, $parameters): static
    {
        if (!method_exists($this->contextBuilder, $method)) {
            throw new BadMethodCallException(sprintf(
                'Method %s::%s does not exist.', static::class, $method
            ));
        }

        $context = $this->contextBuilder->{$method}(...$parameters);

        return $this->withContext($context);
    }
}
