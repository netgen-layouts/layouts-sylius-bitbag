<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\ValueLoader;

use Exception;
use Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\BlockValueLoader;
use Netgen\Layouts\Sylius\BitBag\Repository\BlockRepositoryInterface;
use Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs\Block;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class BlockValueLoaderTest extends TestCase
{
    private MockObject $blockRepositoryMock;

    private BlockValueLoader $valueLoader;

    protected function setUp(): void
    {
        $this->blockRepositoryMock = $this->createMock(BlockRepositoryInterface::class);
        $this->valueLoader = new BlockValueLoader($this->blockRepositoryMock);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\BlockValueLoader::__construct
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\BlockValueLoader::load
     */
    public function testLoad(): void
    {
        $block = new Block(42, 'header', 'Header');

        $this->blockRepositoryMock
            ->expects(self::any())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn($block);

        self::assertSame($block, $this->valueLoader->load(42));
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\BlockValueLoader::load
     */
    public function testLoadWithNoBlock(): void
    {
        $this->blockRepositoryMock
            ->expects(self::any())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn(null);

        self::assertNull($this->valueLoader->load(42));
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\BlockValueLoader::load
     */
    public function testLoadWithRepositoryException(): void
    {
        $this->blockRepositoryMock
            ->expects(self::any())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willThrowException(new Exception());

        self::assertNull($this->valueLoader->load(42));
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\BlockValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteId(): void
    {
        $block = new Block(42, 'header', 'Header');

        $this->blockRepositoryMock
            ->expects(self::any())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn($block);

        self::assertSame($block, $this->valueLoader->loadByRemoteId(42));
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\BlockValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteIdWithNoBlock(): void
    {
        $this->blockRepositoryMock
            ->expects(self::any())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn(null);

        self::assertNull($this->valueLoader->loadByRemoteId(42));
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\BlockValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteIdWithRepositoryException(): void
    {
        $this->blockRepositoryMock
            ->expects(self::any())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willThrowException(new Exception());

        self::assertNull($this->valueLoader->loadByRemoteId(42));
    }
}
