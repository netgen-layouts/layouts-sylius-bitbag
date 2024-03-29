<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\ValueLoader;

use Exception;
use Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\MediaValueLoader;
use Netgen\Layouts\Sylius\BitBag\Repository\MediaRepositoryInterface;
use Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs\Media;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

#[CoversClass(MediaValueLoader::class)]
final class MediaValueLoaderTest extends TestCase
{
    private MockObject&MediaRepositoryInterface $mediaRepositoryMock;

    private MediaValueLoader $valueLoader;

    protected function setUp(): void
    {
        $this->mediaRepositoryMock = $this->createMock(MediaRepositoryInterface::class);
        $this->valueLoader = new MediaValueLoader($this->mediaRepositoryMock);
    }

    public function testLoad(): void
    {
        $media = new Media(42, 'logo-image', 'Logo');

        $this->mediaRepositoryMock
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn($media);

        self::assertSame($media, $this->valueLoader->load(42));
    }

    public function testLoadWithNoMedia(): void
    {
        $this->mediaRepositoryMock
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn(null);

        self::assertNull($this->valueLoader->load(42));
    }

    public function testLoadWithRepositoryException(): void
    {
        $this->mediaRepositoryMock
            ->method('find')
            ->with(self::identicalTo(42))
            ->willThrowException(new Exception());

        self::assertNull($this->valueLoader->load(42));
    }

    public function testLoadByRemoteId(): void
    {
        $media = new Media(42, 'logo-image', 'Logo');

        $this->mediaRepositoryMock
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn($media);

        self::assertSame($media, $this->valueLoader->loadByRemoteId(42));
    }

    public function testLoadByRemoteIdWithNoMedia(): void
    {
        $this->mediaRepositoryMock
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn(null);

        self::assertNull($this->valueLoader->loadByRemoteId(42));
    }

    public function testLoadByRemoteIdWithRepositoryException(): void
    {
        $this->mediaRepositoryMock
            ->method('find')
            ->with(self::identicalTo(42))
            ->willThrowException(new Exception());

        self::assertNull($this->valueLoader->loadByRemoteId(42));
    }
}
