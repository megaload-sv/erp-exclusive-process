<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Core\Relationships;

use App\Libraries\TraceOps\Core\Relationships\Relationship;
use App\Libraries\TraceOps\Core\Relationships\RelationshipRegistry;
use CodeIgniter\Test\CIUnitTestCase;

final class RelationshipEngineTest extends CIUnitTestCase
{
    public function testRegistryCanTraverseRelationshipsBySourceTargetAndType(): void
    {
        $registry = new RelationshipRegistry([
            Relationship::make('component.button', 'supports', 'capability.clickable'),
            Relationship::make('component.button', 'hasProperty', 'property.button.label'),
            Relationship::make('property.button.label', 'hasType', 'type.string'),
        ]);

        self::assertCount(2, $registry->from('component.button'));
        self::assertCount(1, $registry->from('component.button', 'supports'));
        self::assertCount(1, $registry->to('type.string'));
        self::assertCount(1, $registry->ofType('hasProperty'));
        self::assertSame(3, $registry->count());
    }

    public function testDuplicateRelationshipIdentityIsNormalized(): void
    {
        $relationship = Relationship::make('component.button', 'supports', 'capability.clickable');
        $registry = new RelationshipRegistry([$relationship, $relationship]);

        self::assertSame(1, $registry->count());
        self::assertSame(
            'component.button::supports::capability.clickable',
            $relationship->identity()
        );
    }
}
