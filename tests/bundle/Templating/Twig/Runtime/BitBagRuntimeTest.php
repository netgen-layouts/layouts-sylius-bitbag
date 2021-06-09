<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsSyliusBitBagBundle\Tests\Templating\Twig\Runtime;

use Netgen\Bundle\LayoutsSyliusBitBagBundle\Templating\Twig\Runtime\BitBagRuntime;
use Netgen\Layouts\Sylius\BitBag\Tests\Stubs\Page;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Netgen\Layouts\Sylius\BitBag\Repository\PageRepositoryInterface;

final class BitBagRuntimeTest extends TestCase
{
    private MockObject $pageRepositoryMock;

    private BitBagRuntime $runtime;

    protected function setUp(): void
    {
        $this->pageRepositoryMock = $this->createMock(PageRepositoryInterface::class);

        $this->runtime = new BitBagRuntime(
            $this->pageRepositoryMock
        );
    }

    /**
     * @covers \Netgen\Bundle\LayoutsSyliusBitBagBundle\Templating\Twig\Runtime\BitBagRuntime::__construct
     * @covers \Netgen\Bundle\LayoutsSyliusBitBagBundle\Templating\Twig\Runtime\BitBagRuntime::getPageName
     */
    public function testGetPageName(): void
    {
        $page = new Page(15, 'about-us');
        $page->setCurrentLocale('en');
        $page->setName('About us');

        $this->pageRepositoryMock
            ->expects(self::once())
            ->method('find')
            ->with(self::identicalTo(15))
            ->willReturn($page);

        self::assertSame('About us', $this->runtime->getPageName(15));
    }
}
