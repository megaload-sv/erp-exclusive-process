<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Core\Metadata;

use App\Libraries\TraceOps\Core\Metadata\DescriptorSerializer;
use App\Libraries\TraceOps\UI\BaseComponent;
use CodeIgniter\Test\CIUnitTestCase;

final class DescriptorEngineTest extends CIUnitTestCase
{
    public function testComponentCanDescribeItself(): void
    {
        $descriptor = DescriptorFixtureComponent::describe();
        $data = $descriptor->toArray();

        self::assertSame('descriptor-fixture', $data['type']);
        self::assertSame('Descriptor fixture', $data['displayName']);
        self::assertSame('testing', $data['category']);
        self::assertSame(['header', 'body'], $data['slots']);
        self::assertSame(['renderable', 'clickable'], $data['capabilities']);
        self::assertSame(['click'], $data['events']);
        self::assertSame('label', $data['properties'][0]['name']);
        self::assertSame('string', $data['properties'][0]['type']);
        self::assertTrue($data['properties'][0]['required']);
    }

    public function testDescriptorCanBeSerializedToJson(): void
    {
        $json = (new DescriptorSerializer())->toJson(DescriptorFixtureComponent::describe());

        self::assertStringContainsString('"type":"descriptor-fixture"', $json);
        self::assertStringContainsString('"capabilities":["renderable","clickable"]', $json);
    }
}

final class DescriptorFixtureComponent extends BaseComponent
{
    public static function name(): string
    {
        return 'descriptor-fixture';
    }

    public static function view(): string
    {
        return 'traceops/testing/descriptor-fixture';
    }

    public static function schema(): array
    {
        return [
            'label' => [
                'type' => 'string',
                'required' => true,
                'description' => 'Visible label.',
            ],
        ];
    }

    public static function declaredSlots(): array
    {
        return ['header', 'body'];
    }

    public static function capabilities(): array
    {
        return ['renderable', 'clickable'];
    }

    public static function events(): array
    {
        return ['click'];
    }

    public static function displayName(): string
    {
        return 'Descriptor fixture';
    }

    public static function category(): ?string
    {
        return 'testing';
    }
}
