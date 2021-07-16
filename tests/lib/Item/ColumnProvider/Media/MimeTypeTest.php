<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\ColumnProvider\Media;

use Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Media\Item as MediaItem;
use Netgen\Layouts\Sylius\BitBag\Item\ColumnProvider\Media\Type;
use Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs\Media as MediaStub;
use PHPUnit\Framework\TestCase;

final class MimeTypeTest extends TestCase
{
    private Type $typeColumn;

    protected function setUp(): void
    {
        $this->typeColumn = new Type();
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ColumnProvider\Media\Type::getValue
     */
    public function testGetValue(): void
    {
        $media = new MediaStub(5, 'LOGO', 'Logo image', 'image');
        $item = new MediaItem($media);

        self::assertSame('image', $this->typeColumn->getValue($item));
    }
}
