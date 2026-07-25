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
use InvalidArgumentException;

final class RuntimeFacadeTest extends CIUnitTestCase
{
    public function testItNavigatesRegisteredComponents(): void
    {
        $runtime = RuntimeFacade::fromKernel($this->kernel());
        $button = $runtime->component('button');

        self::assertSame('component.button', $button->identity());
        self::assertSame('button', $button->type());
        self::assertSame('Button', $button->title());
        self::assertSame('Semantic action component', $button->summary());
        self::assertContains('clickable', $button->capabilities());
        self::assertNotEmpty($button->properties());
        self::assertSame('components/ui/button', $button->preview()['view']);
        self::assertNotNull($button->knowledge());
    }

    public function testItListsRuntimeComponentsAsObjects(): void
    {
        $runtime = RuntimeFacade::fromKernel($this->kernel());
        $components = $runtime->components();

        self::assertCount(1, $components);
        self::assertSame('component.button', $components[0]->identity());
        self::assertArrayHasKey('components', $runtime->stats());
        self::assertTrue($runtime->health()['Runtime Kernel']);
    }

    public function testItRejectsUnknownComponents(): void
    {
        $runtime = RuntimeFacade::fromKernel($this->kernel());

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Runtime component [missing] is not registered.');

        $runtime->component('missing');
    }

    private function kernel()
    {
        return (new RuntimeKernelBuilder())->build(
            new ComponentRegistry([ButtonComponent::class]),
            new CapabilityRegistry([ClickableCapability::class]),
            new TypeRegistry([StringType::class]),
            new MetadataRegistry([
                'component.button' => SemanticMetadata::make()
                    ->title('Button')
                    ->summary('Semantic action component')
                    ->category('components'),
            ]),
        );
    }
}
