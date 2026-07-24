<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Core\Knowledge;

use App\Libraries\TraceOps\Core\Knowledge\KnowledgeRegistry;
use App\Libraries\TraceOps\Core\Knowledge\SemanticEntity;
use App\Libraries\TraceOps\Core\Relationships\Relationship;
use CodeIgniter\Test\CIUnitTestCase;

final class KnowledgeRegistryTest extends CIUnitTestCase
{
    public function testItRegistersAndResolvesSemanticEntities(): void
    {
        $registry = new KnowledgeRegistry([
            SemanticEntity::make('component.button', 'component', 'button'),
            SemanticEntity::make('type.string', 'type', 'string'),
        ]);

        self::assertTrue($registry->has('component.button'));
        self::assertSame('button', $registry->get('component.button')?->name());
        self::assertCount(1, $registry->ofKind('type'));
    }

    public function testItTraversesConnectedEntities(): void
    {
        $registry = new KnowledgeRegistry([
            SemanticEntity::make('component.button', 'component', 'button'),
            SemanticEntity::make('property.button.label', 'property', 'label'),
            SemanticEntity::make('type.string', 'type', 'string'),
        ]);

        $registry->relate(Relationship::make('component.button', 'hasProperty', 'property.button.label'));
        $registry->relate(Relationship::make('property.button.label', 'hasType', 'type.string'));

        self::assertSame(
            'property.button.label',
            $registry->connectedFrom('component.button', 'hasProperty')[0]->identity()
        );
        self::assertSame(
            'property.button.label',
            $registry->connectedTo('type.string', 'hasType')[0]->identity()
        );
    }

    public function testItCreatesAStableKindSummary(): void
    {
        $registry = new KnowledgeRegistry([
            SemanticEntity::make('component.button', 'component', 'button'),
            SemanticEntity::make('property.button.label', 'property', 'label'),
            SemanticEntity::make('type.string', 'type', 'string'),
        ]);

        self::assertSame([
            'component' => 1,
            'property' => 1,
            'type' => 1,
        ], $registry->summary());
    }
}
