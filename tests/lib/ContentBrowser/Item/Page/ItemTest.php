<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\ContentBrowser\Item\Page;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Page\Item;
use Netgen\Layouts\Sylius\BitBag\Tests\Stubs\Page;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Item::class)]
final class ItemTest extends TestCase
{
    private PageInterface $page;

    private Item $item;

    protected function setUp(): void
    {
        $this->page = new Page(42, 'about-us');
        $this->page->setCurrentLocale('en');
        $this->page->setFallbackLocale('en');
        $this->page->setName('About us');

        $this->item = new Item($this->page);
    }

    public function testGetValue(): void
    {
        self::assertSame(42, $this->item->getValue());
    }

    public function testGetName(): void
    {
        self::assertSame('About us', $this->item->getName());
    }

    public function testIsVisible(): void
    {
        self::assertTrue($this->item->isVisible());
    }

    public function testIsSelectable(): void
    {
        self::assertTrue($this->item->isSelectable());
    }

    public function testGetPage(): void
    {
        self::assertSame($this->page, $this->item->getPage());
    }
}
