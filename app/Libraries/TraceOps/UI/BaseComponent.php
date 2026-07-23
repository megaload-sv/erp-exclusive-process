<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\UI;

abstract class BaseComponent
{
    /**
     * @var array<string, mixed>
     */
    private array $props;

    /**
     * @param array<string, mixed> $props
     */
    final public function __construct(array $props = [])
    {
        $this->props = static::normalize($props);
    }

    abstract public static function name(): string;

    abstract public static function view(): string;

    /**
     * @return array<string, array<string, mixed>>
     */
    abstract public static function schema(): array;

    /**
     * @return array<string, mixed>
     */
    public static function metadata(): array
    {
        return [
            'name' => static::name(),
            'view' => static::view(),
            'schema' => static::schema(),
        ];
    }

    /**
     * @param array<string, mixed> $props
     * @return array<string, mixed>
     */
    final public static function normalize(array $props): array
    {
        return ComponentNormalizer::normalize($props, static::schema());
    }

    /**
     * @return array<string, mixed>
     */
    final public function props(): array
    {
        return $this->props;
    }

    /**
     * Data contract consumed by the component view.
     *
     * @return array<string, mixed>
     */
    final public function toViewData(): array
    {
        return $this->props;
    }
}