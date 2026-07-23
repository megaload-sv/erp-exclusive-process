<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\UI;

use App\Libraries\TraceOps\UI\Components\ButtonComponent;
use PHPUnit\Framework\TestCase;

final class ButtonComponentTest extends TestCase
{
    public function testItExposesItsDefinitionAndMetadata(): void
    {
        $metadata = ButtonComponent::metadata();

        self::assertSame('button', ButtonComponent::name());
        self::assertSame('components/ui/button', ButtonComponent::view());
        self::assertSame('button', $metadata['name']);
        self::assertSame('components/ui/button', $metadata['view']);
        self::assertSame('actions', $metadata['category']);
        self::assertSame('1.0.0', $metadata['version']);
        self::assertSame(
            'Enterprise action button with link and loading support.',
            $metadata['description']
        );
        self::assertSame(ButtonComponent::schema(), $metadata['schema']);
    }

    public function testItDefinesTheExpectedSchema(): void
    {
        $schema = ButtonComponent::schema();

        self::assertSame(
            ['label', 'variant', 'href', 'type', 'disabled', 'loadingLabel', 'class'],
            array_keys($schema)
        );
        self::assertSame('Acción', $schema['label']['default']);
        self::assertSame(
            ['primary', 'secondary', 'ghost', 'danger'],
            $schema['variant']['allowed']
        );
        self::assertSame(['button', 'submit', 'reset'], $schema['type']['allowed']);
        self::assertFalse($schema['disabled']['default']);
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

    public function testItRejectsUnsupportedValuesAndIgnoresUnknownProperties(): void
    {
        $props = ButtonComponent::normalize([
            'variant' => 'unsupported',
            'type' => 'invalid',
            'disabled' => 'unknown',
            'unknown' => 'value',
        ]);

        self::assertSame('primary', $props['variant']);
        self::assertSame('button', $props['type']);
        self::assertFalse($props['disabled']);
        self::assertArrayNotHasKey('unknown', $props);
    }

    public function testItNormalizesValidProperties(): void
    {
        $props = ButtonComponent::normalize([
            'label' => ' Guardar ',
            'variant' => 'danger',
            'href' => ' /orders/1/delete ',
            'type' => 'submit',
            'disabled' => 'yes',
            'loadingLabel' => ' Eliminando… ',
            'class' => ' w-full ',
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
