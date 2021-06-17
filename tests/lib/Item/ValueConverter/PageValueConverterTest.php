<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\ValueConverter;

use BitBag\SyliusCmsPlugin\Entity\Page;
use BitBag\SyliusCmsPlugin\Entity\Section;
use Netgen\Layouts\Sylius\BitBag\Item\ValueConverter\PageValueConverter;
use Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs\Page as PageStub;
use PHPUnit\Framework\TestCase;

final class PageValueConverterTest extends TestCase
{
    private PageValueConverter $valueConverter;

    protected function setUp(): void
    {
        $this->valueConverter = new PageValueConverter();
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueConverter\PageValueConverter::supports
     */
    public function testSupports(): void
    {
        self::assertTrue($this->valueConverter->supports(new Page()));
        self::assertFalse($this->valueConverter->supports(new Section()));
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueConverter\PageValueConverter::getValueType
     */
    public function testGetValueType(): void
    {
        self::assertSame(
            'bitbag_page',
            $this->valueConverter->getValueType(
                new Page(),
            ),
        );
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueConverter\PageValueConverter::getId
     */
    public function testGetId(): void
    {
        self::assertSame(
            42,
            $this->valueConverter->getId(
                new PageStub(42, 'about-us', 'About us'),
            ),
        );
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueConverter\PageValueConverter::getRemoteId
     */
    public function testGetRemoteId(): void
    {
        self::assertSame(
            42,
            $this->valueConverter->getRemoteId(
                new PageStub(42, 'about-us', 'About us'),
            ),
        );
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueConverter\PageValueConverter::getName
     */
    public function testGetName(): void
    {
        self::assertSame(
            'About us',
            $this->valueConverter->getName(
                new PageStub(42, 'about-us', 'About us'),
            ),
        );
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueConverter\PageValueConverter::getIsVisible
     */
    public function testGetIsVisible(): void
    {
        self::assertTrue(
            $this->valueConverter->getIsVisible(
                new PageStub(42, 'about-us', 'About us'),
            ),
        );
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueConverter\PageValueConverter::getObject
     */
    public function testGetObject(): void
    {
        $page = new PageStub(42, 'about-us', 'About us');

        self::assertSame($page, $this->valueConverter->getObject($page));
    }
}
