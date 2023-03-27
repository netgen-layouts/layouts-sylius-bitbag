<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\ContentBrowser\Item\Media;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Media\Item;
use Netgen\Layouts\Sylius\BitBag\Tests\Stubs\Media;
use PHPUnit\Framework\TestCase;

final class ItemTest extends TestCase
{
    private MediaInterface $media;

    private Item $item;

    protected function setUp(): void
    {
        $this->media = new Media(42, 'logo');
        $this->media->setCurrentLocale('en');
        $this->media->setFallbackLocale('en');
        $this->media->setName('Logo');

        $this->item = new Item($this->media);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Media\Item::__construct
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Media\Item::getValue
     */
    public function testGetValue(): void
    {
        self::assertSame(42, $this->item->getValue());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Media\Item::getName
     */
    public function testGetName(): void
    {
        self::assertSame('Logo', $this->item->getName());
    }


    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Media\Item::getName
     */
    public function testGetNameWithEmptyName(): void
    {
        $media = new Media(42, 'logo');

        self::assertSame('logo', $media->getName());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Media\Item::isVisible
     */
    public function testIsVisible(): void
    {
        self::assertTrue($this->item->isVisible());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Media\Item::isSelectable
     */
    public function testIsSelectable(): void
    {
        self::assertTrue($this->item->isSelectable());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Media\Item::getMedia
     */
    public function testGetMedia(): void
    {
        self::assertSame($this->media, $this->item->getMedia());
    }
}
