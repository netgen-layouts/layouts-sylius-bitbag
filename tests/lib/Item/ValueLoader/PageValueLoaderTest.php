<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\ValueLoader;

use Exception;
use Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\PageValueLoader;
use Netgen\Layouts\Sylius\BitBag\Repository\PageRepositoryInterface;
use Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs\Page;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class PageValueLoaderTest extends TestCase
{
    private MockObject&PageRepositoryInterface $pageRepositoryMock;

    private PageValueLoader $valueLoader;

    protected function setUp(): void
    {
        $this->pageRepositoryMock = $this->createMock(PageRepositoryInterface::class);
        $this->valueLoader = new PageValueLoader($this->pageRepositoryMock);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\PageValueLoader::__construct
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\PageValueLoader::load
     */
    public function testLoad(): void
    {
        $page = new Page(42, 'about-us', 'About us');

        $this->pageRepositoryMock
            ->expects(self::any())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn($page);

        self::assertSame($page, $this->valueLoader->load(42));
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\PageValueLoader::load
     */
    public function testLoadWithNoPage(): void
    {
        $this->pageRepositoryMock
            ->expects(self::any())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn(null);

        self::assertNull($this->valueLoader->load(42));
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\PageValueLoader::load
     */
    public function testLoadWithRepositoryException(): void
    {
        $this->pageRepositoryMock
            ->expects(self::any())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willThrowException(new Exception());

        self::assertNull($this->valueLoader->load(42));
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\PageValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteId(): void
    {
        $page = new Page(42, 'about-us', 'About us');

        $this->pageRepositoryMock
            ->expects(self::any())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn($page);

        self::assertSame($page, $this->valueLoader->loadByRemoteId(42));
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\PageValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteIdWithNoPage(): void
    {
        $this->pageRepositoryMock
            ->expects(self::any())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn(null);

        self::assertNull($this->valueLoader->loadByRemoteId(42));
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\PageValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteIdWithRepositoryException(): void
    {
        $this->pageRepositoryMock
            ->expects(self::any())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willThrowException(new Exception());

        self::assertNull($this->valueLoader->loadByRemoteId(42));
    }
}
