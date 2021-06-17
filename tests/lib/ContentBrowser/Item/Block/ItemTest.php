<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\ContentBrowser\Item\Block;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Block\Item;
use Netgen\Layouts\Sylius\BitBag\Tests\Stubs\Block;
use PHPUnit\Framework\TestCase;

final class ItemTest extends TestCase
{
    private BlockInterface $block;

    private Item $item;

    protected function setUp(): void
    {
        $this->block = new Block(42, 'header');
        $this->block->setCurrentLocale('en');
        $this->block->setFallbackLocale('en');
        $this->block->setName('Header');

        $this->item = new Item($this->block);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Block\Item::__construct
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Block\Item::getValue
     */
    public function testGetValue(): void
    {
        self::assertSame(42, $this->item->getValue());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Block\Item::getName
     */
    public function testGetName(): void
    {
        self::assertSame('Header', $this->item->getName());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Block\Item::isVisible
     */
    public function testIsVisible(): void
    {
        self::assertTrue($this->item->isVisible());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Block\Item::isSelectable
     */
    public function testIsSelectable(): void
    {
        self::assertTrue($this->item->isSelectable());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Block\Item::getBlock
     */
    public function testGetBlock(): void
    {
        self::assertSame($this->block, $this->item->getBlock());
    }
}
