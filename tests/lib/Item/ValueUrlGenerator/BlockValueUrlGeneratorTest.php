<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\ValueUrlGenerator;

use Netgen\Layouts\Sylius\BitBag\Item\ValueUrlGenerator\BlockValueUrlGenerator;
use Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs\Block;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class BlockValueUrlGeneratorTest extends TestCase
{
    private MockObject $urlGeneratorMock;

    private BlockValueUrlGenerator $urlGenerator;

    protected function setUp(): void
    {
        $this->urlGeneratorMock = $this->createMock(UrlGeneratorInterface::class);

        $this->urlGenerator = new BlockValueUrlGenerator($this->urlGeneratorMock);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueUrlGenerator\BlockValueUrlGenerator::__construct
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueUrlGenerator\BlockValueUrlGenerator::generate
     */
    public function testGenerate(): void
    {
        $this->urlGeneratorMock
            ->expects(self::once())
            ->method('generate')
            ->with(
                self::identicalTo('bitbag_sylius_cms_plugin_admin_block_update'),
                self::identicalTo(['id' => 42]),
            )
            ->willReturn('/blocks/42/edit');

        self::assertSame(
            '/blocks/42/edit',
            $this->urlGenerator->generate(new Block(42, 'header', 'Header')),
        );
    }
}
