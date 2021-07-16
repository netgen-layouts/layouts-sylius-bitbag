<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\ColumnProvider\Section;

use Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Section\Item as SectionItem;
use Netgen\Layouts\Sylius\BitBag\Item\ColumnProvider\Section\Code;
use Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs\Section as SectionStub;
use PHPUnit\Framework\TestCase;

final class CodeTest extends TestCase
{
    private Code $codeColumn;

    protected function setUp(): void
    {
        $this->codeColumn = new Code();
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ColumnProvider\Section\Code::getValue
     */
    public function testGetValue(): void
    {
        $section = new SectionStub(5, 'BLOG', 'Blog');
        $item = new SectionItem($section);

        self::assertSame('BLOG', $this->codeColumn->getValue($item));
    }
}
