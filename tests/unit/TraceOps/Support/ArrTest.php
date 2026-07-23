<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Support;

use App\Libraries\TraceOps\Support\Arr;
use PHPUnit\Framework\TestCase;

final class ArrTest extends TestCase
{
    public function testItDetectsKeysAndReturnsValues(): void
    {
        $data = ['name' => 'TraceOps', 'nullable' => null];

        self::assertTrue(Arr::has($data, 'name'));
        self::assertTrue(Arr::has($data, 'nullable'));
        self::assertFalse(Arr::has($data, 'missing'));
        self::assertSame('TraceOps', Arr::value($data, 'name'));
        self::assertNull(Arr::value($data, 'nullable', 'fallback'));
        self::assertSame('fallback', Arr::value($data, 'missing', 'fallback'));
    }

    public function testItNormalizesStrings(): void
    {
        $stringable = new class implements \Stringable {
            public function __toString(): string
            {
                return '  component  ';
            }
        };

        self::assertSame('TraceOps', Arr::string(['value' => '  TraceOps  '], 'value'));
        self::assertSame('42', Arr::string(['value' => 42], 'value'));
        self::assertSame('component', Arr::string(['value' => $stringable], 'value'));
        self::assertSame('fallback', Arr::string(['value' => []], 'value', 'fallback'));
        self::assertSame('fallback', Arr::string([], 'value', 'fallback'));
        self::assertSame('Value', Arr::nullableString(['value' => ' Value '], 'value'));
        self::assertNull(Arr::nullableString(['value' => '   '], 'value'));
        self::assertNull(Arr::nullableString([], 'value'));
    }

    public function testItNormalizesBooleans(): void
    {
        self::assertTrue(Arr::bool(['value' => true], 'value'));
        self::assertFalse(Arr::bool(['value' => false], 'value', true));
        self::assertTrue(Arr::bool(['value' => 1], 'value'));
        self::assertFalse(Arr::bool(['value' => 0], 'value', true));
        self::assertTrue(Arr::bool(['value' => ' YES '], 'value'));
        self::assertTrue(Arr::bool(['value' => 'on'], 'value'));
        self::assertFalse(Arr::bool(['value' => 'false'], 'value', true));
        self::assertFalse(Arr::bool(['value' => ''], 'value', true));
        self::assertTrue(Arr::bool(['value' => 'unknown'], 'value', true));
        self::assertFalse(Arr::bool([], 'value'));
    }

    public function testItNormalizesIntegersWithBounds(): void
    {
        self::assertSame(15, Arr::int(['value' => 15], 'value'));
        self::assertSame(15, Arr::int(['value' => '15'], 'value'));
        self::assertSame(8, Arr::int(['value' => 'invalid'], 'value', 8));
        self::assertSame(5, Arr::int(['value' => 2], 'value', 0, 5));
        self::assertSame(10, Arr::int(['value' => 20], 'value', 0, null, 10));
        self::assertSame(7, Arr::int([], 'value', 7, 1, 10));
    }

    public function testItNormalizesArraysCallablesAndEnums(): void
    {
        $callback = static fn (): string => 'ok';

        self::assertSame(['a' => 1], Arr::array(['value' => ['a' => 1]], 'value'));
        self::assertSame(['default'], Arr::array(['value' => 'invalid'], 'value', ['default']));
        self::assertSame($callback, Arr::callable(['value' => $callback], 'value'));
        self::assertNull(Arr::callable(['value' => 'not-callable'], 'value'));
        self::assertSame('primary', Arr::enum(['value' => 'primary'], 'value', ['primary', 'danger'], 'danger'));
        self::assertSame('danger', Arr::enum(['value' => 'invalid'], 'value', ['primary', 'danger'], 'danger'));
        self::assertSame(2, Arr::enum(['value' => 2], 'value', [1, 2], 1));
    }
}
