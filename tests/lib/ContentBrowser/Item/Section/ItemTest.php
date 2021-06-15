<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\ContentBrowser\Item\Section;

use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Section\Item;
use Netgen\Layouts\Sylius\BitBag\Tests\Stubs\Section;
use PHPUnit\Framework\TestCase;

final class ItemTest extends TestCase
{
    private SectionInterface $section;

    private Item $item;

    protected function setUp(): void
    {
        $this->section = new Section(42, 'blog');
        $this->section->setCurrentLocale('en');
        $this->section->setFallbackLocale('en');
        $this->section->setName('Blog posts');

        $this->item = new Item($this->section);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Section\Item::__construct
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Section\Item::getValue
     */
    public function testGetValue(): void
    {
        self::assertSame(42, $this->item->getValue());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Section\Item::getName
     */
    public function testGetName(): void
    {
        self::assertSame('Blog posts', $this->item->getName());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Section\Item::isVisible
     */
    public function testIsVisible(): void
    {
        self::assertTrue($this->item->isVisible());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Section\Item::isSelectable
     */
    public function testIsSelectable(): void
    {
        self::assertTrue($this->item->isSelectable());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Section\Item::getSection
     */
    public function testGetSection(): void
    {
        self::assertSame($this->section, $this->item->getSection());
    }
}
