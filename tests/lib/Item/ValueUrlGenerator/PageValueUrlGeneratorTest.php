<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\ValueUrlGenerator;

use Netgen\Layouts\Sylius\BitBag\Item\ValueUrlGenerator\PageValueUrlGenerator;
use Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs\Page;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class PageValueUrlGeneratorTest extends TestCase
{
    private MockObject $urlGeneratorMock;

    private PageValueUrlGenerator $urlGenerator;

    protected function setUp(): void
    {
        $this->urlGeneratorMock = $this->createMock(UrlGeneratorInterface::class);

        $this->urlGenerator = new PageValueUrlGenerator($this->urlGeneratorMock);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueUrlGenerator\PageValueUrlGenerator::__construct
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueUrlGenerator\PageValueUrlGenerator::generate
     */
    public function testGenerate(): void
    {
        $this->urlGeneratorMock
            ->expects(self::once())
            ->method('generate')
            ->with(
                self::identicalTo('bitbag_sylius_cms_plugin_admin_page_update'),
                self::identicalTo(['id' => 42]),
            )
            ->willReturn('/pages/42/edit');

        self::assertSame(
            '/pages/42/edit',
            $this->urlGenerator->generate(new Page(42, 'about-us', 'About us')),
        );
    }
}
