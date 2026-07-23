<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\UI;

use App\Libraries\TraceOps\UI\Components\ButtonComponent;
use PHPUnit\Framework\TestCase;

final class ButtonComponentTest extends TestCase
{
    public function testItExposesItsDefinition(): void
    {
        self::assertSame('button', ButtonComponent::name());
        self::assertSame('components/ui/button', ButtonComponent::view());
        self::assertSame('actions', ButtonComponent::metadata()['category']);
    }

    public function testItNormalizesDefaultProperties(): void
    {
        $props = ButtonComponent::normalize([]);

        self::assertSame('Acción', $props['label']);
        self::assertSame('primary', $props['variant']);
        self::assertSame('button', $props['type']);
        self::assertFalse($props['disabled']);
        self::assertNull($props['href']);
        self::assertNull($props['loadingLabel']);
        self::assertSame('', $props['class']);
    }

    public function testItRejectsUnsupportedEnumValues(): void
    {
        $props = ButtonComponent::normalize([
            'variant' => 'unsupported',
            'type' => 'invalid',
        ]);

        self::assertSame('primary', $props['variant']);
        self::assertSame('button', $props['type']);
    }

    public function testItNormalizesValidProperties(): void
    {
        $props = ButtonComponent::normalize([
            'label' => 'Guardar',
            'variant' => 'danger',
            'href' => '/orders/1/delete',
            'type' => 'submit',
            'disabled' => true,
            'loadingLabel' => 'Eliminando…',
            'class' => 'w-full',
        ]);

        self::assertSame('Guardar', $props['label']);
        self::assertSame('danger', $props['variant']);
        self::assertSame('/orders/1/delete', $props['href']);
        self::assertSame('submit', $props['type']);
        self::assertTrue($props['disabled']);
        self::assertSame('Eliminando…', $props['loadingLabel']);
        self::assertSame('w-full', $props['class']);
    }
}
