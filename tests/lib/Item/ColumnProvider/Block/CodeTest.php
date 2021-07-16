<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\ColumnProvider\Block;

use Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Block\Item as BlockItem;
use Netgen\Layouts\Sylius\BitBag\Item\ColumnProvider\Block\Code;
use Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs\Block as BlockStub;
use PHPUnit\Framework\TestCase;

class CodeTest extends TestCase
{
    private Code $codeColumn;

    protected function setUp(): void
    {
        $this->codeColumn = new Code();
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ColumnProvider\Block\Code::getValue
     */
    public function testGetValue(): void
    {
        $block = new BlockStub(5, 'FOOTER', 'Footer block');
        $item = new BlockItem($block);

        self::assertSame('FOOTER', $this->codeColumn->getValue($item));
    }
}
