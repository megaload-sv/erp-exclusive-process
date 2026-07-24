<?php

declare(strict_types=1);

namespace App\Libraries\TraceOps\UI;

use App\Libraries\TraceOps\Core\Metadata\ComponentDescriptor;
use App\Libraries\TraceOps\Core\Tree\AbstractNode;

abstract class BaseComponent extends AbstractNode
{
    /** @var array<string, mixed> */
    private array $props;

    /** @param array<string, mixed> $props */
    final public function __construct(array $props = [])
    {
        parent::__construct();
        $this->props = static::normalize($props);
    }

    abstract public static function name(): string;

    abstract public static function view(): string;

    /** @return array<string, array<string, mixed>> */
    abstract public static function schema(): array;

    /** @return list<string> */
    public static function declaredSlots(): array
    {
        return [];
    }

    /** @return list<string> */
    public static function capabilities(): array
    {
        return ['renderable'];
    }

    /** @return list<string> */
    public static function events(): array
    {
        return [];
    }

    public static function displayName(): string
    {
        return ucfirst(str_replace(['-', '_'], ' ', static::name()));
    }

    public static function category(): ?string
    {
        return null;
    }

    final public function nodeName(): string
    {
        return static::name();
    }

    final public static function describe(): ComponentDescriptor
    {
        return ComponentDescriptor::fromComponent(
            className: static::class,
            type: static::name(),
            view: static::view(),
            schema: static::schema(),
            slots: static::declaredSlots(),
            capabilities: static::capabilities(),
            events: static::events(),
            displayName: static::displayName(),
            category: static::category(),
        );
    }

    /** @return array<string, mixed> */
    public static function metadata(): array
    {
        return static::describe()->toArray();
    }

    /**
     * @param array<string, mixed> $props
     * @return array<string, mixed>
     */
    final public static function normalize(array $props): array
    {
        return ComponentNormalizer::normalize($props, static::schema());
    }

    /** @return array<string, mixed> */
    final public function props(): array
    {
        return $this->props;
    }

    /** @return array<string, mixed> */
    final public function toViewData(): array
    {
        return $this->props;
    }
}
