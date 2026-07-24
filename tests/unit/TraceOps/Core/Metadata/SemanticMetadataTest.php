<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Core\Metadata;

use App\Libraries\TraceOps\Core\Metadata\MetadataRegistry;
use App\Libraries\TraceOps\Core\Metadata\SemanticMetadata;
use CodeIgniter\Test\CIUnitTestCase;

final class SemanticMetadataTest extends CIUnitTestCase
{
    public function testMetadataSerializesStableSemanticFields(): void
    {
        $metadata = SemanticMetadata::make()
            ->title('Email')
            ->summary('Corporate email')
            ->group('General')
            ->placeholder('john@company.com')
            ->tags('identity', 'contact')
            ->example('john@traceops.dev')
            ->order(10);

        $data = $metadata->toArray();

        self::assertSame('Email', $data['title']);
        self::assertSame('General', $data['group']);
        self::assertSame(['identity', 'contact'], $data['tags']);
        self::assertSame(['john@traceops.dev'], $data['examples']);
        self::assertSame(10, $data['order']);
    }

    public function testRegistryFindsMetadataBySemanticIdentity(): void
    {
        $registry = new MetadataRegistry([
            'property.customer.email' => SemanticMetadata::make()->title('Customer email'),
        ]);

        self::assertTrue($registry->has('property.customer.email'));
        self::assertSame('Customer email', $registry->get('property.customer.email')->toArray()['title']);
        self::assertSame(1, $registry->count());
    }
}