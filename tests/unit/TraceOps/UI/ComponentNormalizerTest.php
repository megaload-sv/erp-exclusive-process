<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\UI;

use App\Libraries\TraceOps\UI\ComponentNormalizer;
use PHPUnit\Framework\TestCase;

final class ComponentNormalizerTest extends TestCase
{
    public function testItNormalizesACompleteSchema(): void
    {
        $callback = static fn (): string => 'ok';
        $schema = [
            'label' => ['type' => 'string', 'default' => 'Acción'],
            'href' => ['type' => 'nullable-string'],
            'disabled' => ['type' => 'bool', 'default' => false],
            'page' => ['type' => 'int', 'default' => 1, 'min' => 1, 'max' => 100],
            'items' => ['type' => 'array', 'default' => []],
            'handler' => ['type' => 'callable'],
            'variant' => [
                'type' => 'enum',
                'allowed' => ['primary', 'danger'],
                'default' => 'primary',
            ],
        ];

        $normalized = ComponentNormalizer::normalize([
            'label' => ' Guardar ',
            'href' => ' /orders ',
            'disabled' => 'yes',
            'page' => 150,
            'items' => ['a', 'b'],
            'handler' => $callback,
            'variant' => 'danger',
            'ignored' => 'value',
        ], $schema);

        self::assertSame('Guardar', $normalized['label']);
        self::assertSame('/orders', $normalized['href']);
        self::assertTrue($normalized['disabled']);
        self::assertSame(100, $normalized['page']);
        self::assertSame(['a', 'b'], $normalized['items']);
        self::assertSame($callback, $normalized['handler']);
        self::assertSame('danger', $normalized['variant']);
        self::assertArrayNotHasKey('ignored', $normalized);
    }

    public function testItUsesSchemaDefaultsForInvalidOrMissingValues(): void
    {
        $normalized = ComponentNormalizer::normalize([
            'label' => [],
            'href' => ' ',
            'disabled' => 'unknown',
            'page' => 'invalid',
            'items' => 'invalid',
            'handler' => 'not-callable',
            'variant' => 'unsupported',
        ], [
            'label' => ['type' => 'string', 'default' => 'Acción'],
            'href' => ['type' => 'nullable-string'],
            'disabled' => ['type' => 'bool', 'default' => true],
            'page' => ['type' => 'int', 'default' => 5, 'min' => 1, 'max' => 10],
            'items' => ['type' => 'array', 'default' => ['default']],
            'handler' => ['type' => 'callable'],
            'variant' => [
                'type' => 'enum',
                'allowed' => ['primary', 'danger'],
                'default' => 'primary',
            ],
        ]);

        self::assertSame('Acción', $normalized['label']);
        self::assertNull($normalized['href']);
        self::assertTrue($normalized['disabled']);
        self::assertSame(5, $normalized['page']);
        self::assertSame(['default'], $normalized['items']);
        self::assertNull($normalized['handler']);
        self::assertSame('primary', $normalized['variant']);
    }

    public function testUnknownTypesFallBackToStringNormalization(): void
    {
        $normalized = ComponentNormalizer::normalize(
            ['value' => ' TraceOps '],
            ['value' => ['type' => 'unknown', 'default' => 'fallback']]
        );

        self::assertSame('TraceOps', $normalized['value']);
    }

    public function testItCreatesSafeIdentifiers(): void
    {
        self::assertSame('customer-table', ComponentNormalizer::id('Customer Table'));
        self::assertSame('accion-rapida', ComponentNormalizer::id('Acción rápida'));
        self::assertSame('component', ComponentNormalizer::id(''));
        self::assertSame('field', ComponentNormalizer::id(null, 'field'));
    }

    public function testItFiltersUnsafeHtmlAttributes(): void
    {
        $attributes = ComponentNormalizer::attributes([
            'data-id' => 15,
            'aria-label' => 'Guardar',
            'x-bind:disabled' => 'loading',
            'class' => 'w-full',
            'checked' => true,
            'nullable' => null,
            'array' => ['invalid'],
            'object' => new \stdClass(),
            'invalid name' => 'value',
            10 => 'numeric-key',
        ]);

        self::assertSame(15, $attributes['data-id']);
        self::assertSame('Guardar', $attributes['aria-label']);
        self::assertSame('loading', $attributes['x-bind:disabled']);
        self::assertSame('w-full', $attributes['class']);
        self::assertTrue($attributes['checked']);
        self::assertArrayNotHasKey('nullable', $attributes);
        self::assertArrayNotHasKey('array', $attributes);
        self::assertArrayNotHasKey('object', $attributes);
        self::assertArrayNotHasKey('invalid name', $attributes);
        self::assertCount(5, $attributes);
    }

    public function testAttributesRejectsNonArrayInput(): void
    {
        self::assertSame([], ComponentNormalizer::attributes(null));
        self::assertSame([], ComponentNormalizer::attributes('data-id'));
        self::assertSame([], ComponentNormalizer::attributes(new \stdClass()));
    }
}
