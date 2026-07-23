<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Core\Tree;

use App\Libraries\TraceOps\Core\Tree\TreeWalker;
use App\Libraries\TraceOps\UI\Components\ButtonComponent;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class ComponentCompositionTest extends TestCase
{
    public function testItBuildsAndNavigatesAComponentTree(): void
    {
        $page = new ButtonComponent(['label' => 'Page']);
        $toolbar = new ButtonComponent(['label' => 'Toolbar']);
        $action = new ButtonComponent(['label' => 'Guardar']);

        $page->addChild($toolbar);
        $toolbar->addChild($action);

        self::assertSame($toolbar, $action->parent());
        self::assertSame($page, $action->root());
        self::assertSame(2, $action->depth());
        self::assertSame(['button', 'button', 'button'], $action->path());
        self::assertCount(1, $page->children());
    }

    public function testItReparentsAndRemovesNodesSafely(): void
    {
        $firstParent = new ButtonComponent();
        $secondParent = new ButtonComponent();
        $child = new ButtonComponent();

        $firstParent->addChild($child);
        $secondParent->addChild($child);

        self::assertCount(0, $firstParent->children());
        self::assertSame($secondParent, $child->parent());

        $secondParent->removeChild($child);

        self::assertNull($child->parent());
        self::assertSame($child, $child->root());
    }

    public function testItWalksAndSearchesTheTreeDepthFirst(): void
    {
        $root = new ButtonComponent(['label' => 'Root']);
        $first = new ButtonComponent(['label' => 'First']);
        $second = new ButtonComponent(['label' => 'Second']);

        $root->addChild($first);
        $first->addChild($second);

        $walker = new TreeWalker();

        self::assertSame([$root, $first, $second], $walker->depthFirst($root));
        self::assertSame($second, $walker->findFirst(
            $root,
            static fn (ButtonComponent $node): bool => $node->props()['label'] === 'Second'
        ));
        self::assertCount(3, $walker->findByName($root, 'button'));
        self::assertCount(3, $walker->findByType($root, ButtonComponent::class));
    }

    public function testItRejectsCircularComposition(): void
    {
        $root = new ButtonComponent();
        $child = new ButtonComponent();
        $root->addChild($child);

        $this->expectException(InvalidArgumentException::class);

        $child->addChild($root);
    }
}