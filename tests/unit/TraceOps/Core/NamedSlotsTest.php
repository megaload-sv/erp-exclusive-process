<?php

declare(strict_types=1);

namespace Tests\Unit\TraceOps\Core;

use App\Libraries\TraceOps\Core\Tree\TreeWalker;
use App\Libraries\TraceOps\UI\Components\ButtonComponent;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class NamedSlotsTest extends TestCase
{
    public function testItAssignsAndReadsNamedSlots(): void
    {
        $card = new ButtonComponent(['label' => 'Card']);
        $header = new ButtonComponent(['label' => 'Header']);
        $body = new ButtonComponent(['label' => 'Body']);

        $card->setSlot('header', $header)
            ->setSlot('body', $body);

        self::assertSame([$header], $card->slot('header')->all());
        self::assertSame([$body], $card->slot('body')->all());
        self::assertSame(['header', 'body'], $card->slots()->names());
        self::assertSame($card, $header->parent());
        self::assertSame(1, $body->depth());
    }

    public function testReplacingASlotDetachesPreviousNodes(): void
    {
        $card = new ButtonComponent(['label' => 'Card']);
        $first = new ButtonComponent(['label' => 'First']);
        $replacement = new ButtonComponent(['label' => 'Replacement']);

        $card->setSlot('header', $first);
        $card->setSlot('header', $replacement);

        self::assertNull($first->parent());
        self::assertSame([$replacement], $card->slot('header')->all());
        self::assertSame($card, $replacement->parent());
    }

    public function testReparentingRemovesNodeFromItsPreviousSlot(): void
    {
        $firstParent = new ButtonComponent(['label' => 'First parent']);
        $secondParent = new ButtonComponent(['label' => 'Second parent']);
        $child = new ButtonComponent(['label' => 'Child']);

        $firstParent->addToSlot('body', $child);
        $secondParent->addChild($child);

        self::assertCount(0, $firstParent->slot('body'));
        self::assertSame($secondParent, $child->parent());
        self::assertSame([$child], $secondParent->children()->all());
    }

    public function testTreeWalkerIncludesSlottedNodes(): void
    {
        $page = new ButtonComponent(['label' => 'Page']);
        $header = new ButtonComponent(['label' => 'Header']);
        $action = new ButtonComponent(['label' => 'Action']);

        $page->setSlot('header', $header);
        $header->addToSlot('actions', $action);

        self::assertSame([$page, $header, $action], (new TreeWalker())->depthFirst($page));
    }

    public function testItRejectsInvalidSlotNames(): void
    {
        $this->expectException(InvalidArgumentException::class);

        (new ButtonComponent(['label' => 'Card']))
            ->setSlot('Invalid Slot', new ButtonComponent(['label' => 'Header']));
    }
}
