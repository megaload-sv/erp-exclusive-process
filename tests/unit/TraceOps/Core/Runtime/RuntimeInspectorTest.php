<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Core\Runtime;

use App\Libraries\TraceOps\Core\Capabilities\CapabilityRegistry;
use App\Libraries\TraceOps\Core\Capabilities\ClickableCapability;
use App\Libraries\TraceOps\Core\Metadata\MetadataRegistry;
use App\Libraries\TraceOps\Core\Metadata\SemanticMetadata;
use App\Libraries\TraceOps\Core\Runtime\Navigation\RuntimeFacade;
use App\Libraries\TraceOps\Core\Runtime\RuntimeKernelBuilder;
use App\Libraries\TraceOps\Core\Types\StringType;
use App\Libraries\TraceOps\Core\Types\TypeRegistry;
use App\Libraries\TraceOps\UI\ComponentRegistry;
use App\Libraries\TraceOps\UI\Components\ButtonComponent;
use CodeIgniter\Test\CIUnitTestCase;

final class RuntimeInspectorTest extends CIUnitTestCase
{
    public function testItBuildsAStableComponentInspectionModel(): void
    {
        $runtime = RuntimeFacade::fromKernel((new RuntimeKernelBuilder())->build(
            new ComponentRegistry([ButtonComponent::class]),
            new CapabilityRegistry([ClickableCapability::class]),
            new TypeRegistry([StringType::class]),
            new MetadataRegistry([
                'component.button' => SemanticMetadata::make()
                    ->title('Button')
                    ->summary('Semantic action component'),
            ]),
        ));

        $inspection = $runtime->component('button')->inspector()->describe();

        self::assertSame('component.button', $inspection['general']['identity']);
        self::assertSame('Button', $inspection['general']['title']);
        self::assertNotEmpty($inspection['properties']);
        self::assertContains('clickable', $inspection['capabilities']);
        self::assertSame('components/ui/button', $inspection['preview']['view']);
        self::assertTrue($inspection['diagnostics']['hasMetadata']);
        self::assertTrue($inspection['diagnostics']['hasPreview']);
        self::assertGreaterThan(0, $inspection['diagnostics']['propertyCount']);
    }
}
