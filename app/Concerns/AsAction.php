<?php

namespace App\Concerns;

trait AsAction
{
    /**
     * @return static
     */
    public static function make(): static
    {
        return app(static::class);
    }

    /**
     * @param mixed ...$arguments
     * @return static
     * @see static::set()
     */
    public static function initialize(mixed ...$arguments): static
    {
        $instance = static::make();
        if (method_exists(static::class, 'set')) {
            $instance->set(...$arguments);
        }

        return $instance;
    }

    /**
     * @param mixed ...$arguments
     * @return mixed
     * @see static::handle()
     */
    public static function run(...$arguments): mixed
    {
        $instance = static::make();
        if (method_exists(static::class, 'handle')) {
            return $instance->handle(...$arguments);
        }

        return $instance;
    }
}
