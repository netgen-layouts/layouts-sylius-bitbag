<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\ColumnProvider\Page;

use Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Page\Item as PageItem;
use Netgen\Layouts\Sylius\BitBag\Item\ColumnProvider\Page\Code;
use Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs\Page as PageStub;
use PHPUnit\Framework\TestCase;

class CodeTest extends TestCase
{
    private Code $codeColumn;

    protected function setUp(): void
    {
        $this->codeColumn = new Code();
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ColumnProvider\Page\Code::getValue
     */
    public function testGetValue(): void
    {
        $page = new PageStub(5, 'ABOUT_US', 'About us');
        $item = new PageItem($page);

        self::assertSame('ABOUT_US', $this->codeColumn->getValue($item));
    }
}
