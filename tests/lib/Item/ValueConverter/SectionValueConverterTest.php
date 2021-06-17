<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\ValueConverter;

use BitBag\SyliusCmsPlugin\Entity\Page;
use BitBag\SyliusCmsPlugin\Entity\Section;
use Netgen\Layouts\Sylius\BitBag\Item\ValueConverter\SectionValueConverter;
use Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs\Section as SectionStub;
use PHPUnit\Framework\TestCase;

final class SectionValueConverterTest extends TestCase
{
    private SectionValueConverter $valueConverter;

    protected function setUp(): void
    {
        $this->valueConverter = new SectionValueConverter();
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueConverter\SectionValueConverter::supports
     */
    public function testSupports(): void
    {
        self::assertTrue($this->valueConverter->supports(new Section()));
        self::assertFalse($this->valueConverter->supports(new Page()));
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueConverter\SectionValueConverter::getValueType
     */
    public function testGetValueType(): void
    {
        self::assertSame(
            'bitbag_section',
            $this->valueConverter->getValueType(
                new Section(),
            ),
        );
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueConverter\SectionValueConverter::getId
     */
    public function testGetId(): void
    {
        self::assertSame(
            42,
            $this->valueConverter->getId(
                new SectionStub(42, 'blog', 'Blog'),
            ),
        );
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueConverter\SectionValueConverter::getRemoteId
     */
    public function testGetRemoteId(): void
    {
        self::assertSame(
            42,
            $this->valueConverter->getRemoteId(
                new SectionStub(42, 'blog', 'Blog'),
            ),
        );
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueConverter\SectionValueConverter::getName
     */
    public function testGetName(): void
    {
        self::assertSame(
            'Blog',
            $this->valueConverter->getName(
                new SectionStub(42, 'blog', 'Blog'),
            ),
        );
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueConverter\SectionValueConverter::getIsVisible
     */
    public function testGetIsVisible(): void
    {
        self::assertTrue(
            $this->valueConverter->getIsVisible(
                new SectionStub(42, 'blog', 'Blog'),
            ),
        );
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueConverter\SectionValueConverter::getObject
     */
    public function testGetObject(): void
    {
        $section = new SectionStub(42, 'blog', 'Blog');

        self::assertSame($section, $this->valueConverter->getObject($section));
    }
}
