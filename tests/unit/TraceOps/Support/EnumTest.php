<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Support;

use App\Libraries\TraceOps\Support\Enum;
use PHPUnit\Framework\TestCase;

final class EnumTest extends TestCase
{
    public function testItReturnsAllowedValues(): void
    {
        self::assertSame('primary', Enum::value('primary', ['primary', 'danger'], 'danger'));
        self::assertSame('danger', Enum::value('danger', ['primary', 'danger'], 'primary'));
        self::assertSame(2, Enum::value(2, [1, 2, 3], 1));
    }

    public function testItReturnsDefaultForUnsupportedValues(): void
    {
        self::assertSame('primary', Enum::value('unknown', ['primary', 'danger'], 'primary'));
        self::assertSame(1, Enum::value(4, [1, 2, 3], 1));
        self::assertSame('fallback', Enum::value(null, ['a', 'b'], 'fallback'));
        self::assertSame('fallback', Enum::value([], ['a', 'b'], 'fallback'));
        self::assertSame('fallback', Enum::value(true, ['a', 'b'], 'fallback'));
    }

    public function testItHonorsCaseSensitivity(): void
    {
        self::assertSame('fallback', Enum::value('PRIMARY', ['primary'], 'fallback'));
        self::assertSame('primary', Enum::value('PRIMARY', ['primary'], 'fallback', false));
        self::assertSame('Primary', Enum::value(' primary ', ['Primary'], 'fallback', false));
        self::assertSame(2, Enum::value(2, [1, 2], 1, false));
        self::assertSame(1, Enum::value(3, [1, 2], 1, false));
    }

    public function testNullableReturnsAllowedValuesOrNull(): void
    {
        self::assertSame('primary', Enum::nullable('primary', ['primary', 'danger']));
        self::assertSame(2, Enum::nullable(2, [1, 2, 3]));
        self::assertNull(Enum::nullable('unknown', ['primary', 'danger']));
        self::assertNull(Enum::nullable(null, ['primary', 'danger']));
        self::assertNull(Enum::nullable([], ['primary', 'danger']));
    }

    public function testNullableCanMatchStringsWithoutCaseSensitivity(): void
    {
        self::assertNull(Enum::nullable('PRIMARY', ['primary']));
        self::assertSame('primary', Enum::nullable('PRIMARY', ['primary'], false));
        self::assertSame('Primary', Enum::nullable(' primary ', ['Primary'], false));
        self::assertSame(2, Enum::nullable(2, [1, 2], false));
        self::assertNull(Enum::nullable(3, [1, 2], false));
    }
}
