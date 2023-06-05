<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\ValueLoader;

use Exception;
use Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\SectionValueLoader;
use Netgen\Layouts\Sylius\BitBag\Repository\SectionRepositoryInterface;
use Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs\Section;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

#[CoversClass(SectionValueLoader::class)]
final class SectionValueLoaderTest extends TestCase
{
    private MockObject&SectionRepositoryInterface $sectionRepositoryMock;

    private SectionValueLoader $valueLoader;

    protected function setUp(): void
    {
        $this->sectionRepositoryMock = $this->createMock(SectionRepositoryInterface::class);
        $this->valueLoader = new SectionValueLoader($this->sectionRepositoryMock);
    }

    public function testLoad(): void
    {
        $section = new Section(42, 'blog', 'Blog');

        $this->sectionRepositoryMock
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn($section);

        self::assertSame($section, $this->valueLoader->load(42));
    }

    public function testLoadWithNoSection(): void
    {
        $this->sectionRepositoryMock
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn(null);

        self::assertNull($this->valueLoader->load(42));
    }

    public function testLoadWithRepositoryException(): void
    {
        $this->sectionRepositoryMock
            ->method('find')
            ->with(self::identicalTo(42))
            ->willThrowException(new Exception());

        self::assertNull($this->valueLoader->load(42));
    }

    public function testLoadByRemoteId(): void
    {
        $section = new Section(42, 'blog', 'Blog');

        $this->sectionRepositoryMock
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn($section);

        self::assertSame($section, $this->valueLoader->loadByRemoteId(42));
    }

    public function testLoadByRemoteIdWithNoSection(): void
    {
        $this->sectionRepositoryMock
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn(null);

        self::assertNull($this->valueLoader->loadByRemoteId(42));
    }

    public function testLoadByRemoteIdWithRepositoryException(): void
    {
        $this->sectionRepositoryMock
            ->method('find')
            ->with(self::identicalTo(42))
            ->willThrowException(new Exception());

        self::assertNull($this->valueLoader->loadByRemoteId(42));
    }
}
