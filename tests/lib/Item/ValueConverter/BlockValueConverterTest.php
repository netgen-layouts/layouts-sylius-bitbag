<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\ValueConverter;

use BitBag\SyliusCmsPlugin\Entity\Block;
use BitBag\SyliusCmsPlugin\Entity\Section;
use Netgen\Layouts\Sylius\BitBag\Item\ValueConverter\BlockValueConverter;
use Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs\Block as BlockStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BlockValueConverter::class)]
final class BlockValueConverterTest extends TestCase
{
    private BlockValueConverter $valueConverter;

    protected function setUp(): void
    {
        $this->valueConverter = new BlockValueConverter();
    }

    public function testSupports(): void
    {
        self::assertTrue($this->valueConverter->supports(new Block()));
        self::assertFalse($this->valueConverter->supports(new Section()));
    }

    public function testGetValueType(): void
    {
        self::assertSame(
            'bitbag_block',
            $this->valueConverter->getValueType(
                new Block(),
            ),
        );
    }

    public function testGetId(): void
    {
        self::assertSame(
            42,
            $this->valueConverter->getId(
                new BlockStub(42, 'header', 'Header'),
            ),
        );
    }

    public function testGetRemoteId(): void
    {
        self::assertSame(
            42,
            $this->valueConverter->getRemoteId(
                new BlockStub(42, 'header', 'Header'),
            ),
        );
    }

    public function testGetName(): void
    {
        self::assertSame(
            'Header',
            $this->valueConverter->getName(
                new BlockStub(42, 'header', 'Header'),
            ),
        );
    }

    public function testGetIsVisible(): void
    {
        self::assertTrue(
            $this->valueConverter->getIsVisible(
                new BlockStub(42, 'header', 'Header'),
            ),
        );

        self::assertFalse(
            $this->valueConverter->getIsVisible(
                new BlockStub(42, 'header', 'Header', false),
            ),
        );
    }

    public function testGetObject(): void
    {
        $block = new BlockStub(42, 'header', 'Header');

        self::assertSame($block, $this->valueConverter->getObject($block));
    }
}
