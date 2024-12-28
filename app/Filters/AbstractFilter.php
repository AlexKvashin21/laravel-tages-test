<?php

declare(strict_types=1);

namespace App\Filters;

use App\Contracts\FilterContract;
use Illuminate\Database\Eloquent\Builder as BuilderContract;

class AbstractFilter implements FilterContract
{
    /** @var array $queryParams */
    private array $queryParams = [];
    private array $with = [];
    private array $select = [];
    private int $limit;

    /**
     * AbstractFilter constructor.
     *
     * @param array $queryParams
     */
    public function __construct(array $queryParams)
    {
        $this->queryParams = $queryParams;
    }


    /**
     * @param BuilderContract $builder
     * @return void
     */
    public function apply(BuilderContract $builder): void
    {
        $this->before($builder);

        if (count($this->with)) {
            $builder->with($this->with);
        }

        if (!empty($this->limit)) {
            $builder->limit($this->limit);
        }

        foreach ($this->getCallbacks() as $name => $callback) {
            if (isset($this->queryParams[$name])) {
                call_user_func($callback, $builder, $this->queryParams[$name]);
            }
        }

        if (count($this->select)) {
            $builder->select($this->select);
        }

        $this->after($builder);
    }

    public function select(array $fields): self
    {
        $this->select = $fields;

        return $this;
    }

    public function with(array $relations): self
    {
        $this->with = $relations;

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @param BuilderContract $builder
     */
    protected function before(BuilderContract $builder)
    {
    }

    /**
     * @param BuilderContract $builder
     */
    protected function after(BuilderContract $builder): void
    {
        $builder->latest();
    }

    /**
     * @param string $key
     * @param mixed|null $default
     *
     * @return mixed|null
     */
    protected function getQueryParam(string $key, mixed $default = null): mixed
    {
        return $this->queryParams[$key] ?? $default;
    }

    /**
     * @param string[] $keys
     *
     * @return AbstractFilter
     */
    protected function removeQueryParam(string ...$keys)
    {
        foreach ($keys as $key) {
            unset($this->queryParams[$key]);
        }

        return $this;
    }
}
