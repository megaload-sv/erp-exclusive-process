<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Support;

use App\Libraries\TraceOps\Support\Str;
use PHPUnit\Framework\TestCase;

final class StrTest extends TestCase
{
    public function testItNormalizesScalarAndStringableValues(): void
    {
        $stringable = new class implements \Stringable {
            public function __toString(): string
            {
                return '  TraceOps Component  ';
            }
        };

        self::assertSame('TraceOps', Str::value('  TraceOps  '));
        self::assertSame('42', Str::value(42));
        self::assertSame('3.5', Str::value(3.5));
        self::assertSame('TraceOps Component', Str::value($stringable));
        self::assertSame('fallback', Str::value([], 'fallback'));
        self::assertSame('fallback', Str::value(null, 'fallback'));
    }

    public function testItReturnsNullableStrings(): void
    {
        self::assertSame('TraceOps', Str::nullable(' TraceOps '));
        self::assertSame('0', Str::nullable(0));
        self::assertNull(Str::nullable('   '));
        self::assertNull(Str::nullable(null));
        self::assertNull(Str::nullable([]));
    }

    public function testItCreatesSlugs(): void
    {
        self::assertSame('traceops-platform', Str::slug('TraceOps Platform'));
        self::assertSame('accion-rapida', Str::slug('Acción rápida'));
        self::assertSame('customer_record', Str::slug('Customer Record', '_'));
        self::assertSame('customer-record', Str::slug(' Customer---Record '));
        self::assertSame('customer-record', Str::slug('Customer Record', ''));
        self::assertSame('', Str::slug('   '));
        self::assertSame('', Str::slug(null));
    }

    public function testItCreatesIdentifiersWithFallbacks(): void
    {
        self::assertSame('button-primary', Str::identifier('Button Primary'));
        self::assertSame('component', Str::identifier(''));
        self::assertSame('field', Str::identifier(null, 'field'));
        self::assertSame('123', Str::identifier(123));
    }

    public function testItDetectsPrefixesAfterNormalization(): void
    {
        self::assertTrue(Str::startsWith(' traceops-button', 'traceops'));
        self::assertTrue(Str::startsWith(12345, '123'));
        self::assertTrue(Str::startsWith('', ''));
        self::assertFalse(Str::startsWith('button', 'table'));
        self::assertFalse(Str::startsWith([], 'traceops'));
    }
}
