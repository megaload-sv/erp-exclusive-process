<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Core\Types;

use App\Libraries\TraceOps\Core\Metadata\PropertyDescriptor;
use App\Libraries\TraceOps\Core\Properties\Property;
use App\Libraries\TraceOps\Core\Types\BooleanType;
use App\Libraries\TraceOps\Core\Types\EmailType;
use App\Libraries\TraceOps\Core\Types\StringType;
use App\Libraries\TraceOps\Core\Types\TypeRegistry;
use App\Libraries\TraceOps\Core\Types\TypeResolver;
use PHPUnit\Framework\TestCase;

final class SemanticTypeSystemTest extends TestCase
{
    public function testRegistryResolvesNamesAndClasses(): void
    {
        $registry = new TypeRegistry([StringType::class, EmailType::class]);
        $resolver = new TypeResolver($registry);

        self::assertTrue($registry->has('email'));
        self::assertSame(EmailType::class, $resolver->resolve('email'));
        self::assertSame('email', $resolver->name(EmailType::class));
        self::assertSame('email', $resolver->input('email'));
    }

    public function testPropertyBuildsReusableSemanticSchema(): void
    {
        $property = Property::make('email')
            ->label('Corporate email')
            ->type(EmailType::class)
            ->required()
            ->searchable()
            ->validation('email');

        $descriptor = PropertyDescriptor::fromSchema($property->name(), $property->toSchema());
        $data = $descriptor->toArray();

        self::assertSame('email', $data['type']);
        self::assertTrue($data['required']);
        self::assertTrue($data['searchable']);
        self::assertSame(['email'], $data['validation']);
    }

    public function testBooleanTypeRecommendsSwitchInput(): void
    {
        self::assertSame('switch', BooleanType::input());
    }
}