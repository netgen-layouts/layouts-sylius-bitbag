<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\ValueUrlGenerator;

use Netgen\Layouts\Sylius\BitBag\Item\ValueUrlGenerator\MediaValueUrlGenerator;
use Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs\Media;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class MediaValueUrlGeneratorTest extends TestCase
{
    private MockObject $urlGeneratorMock;

    private MediaValueUrlGenerator $urlGenerator;

    protected function setUp(): void
    {
        $this->urlGeneratorMock = $this->createMock(UrlGeneratorInterface::class);

        $this->urlGenerator = new MediaValueUrlGenerator($this->urlGeneratorMock);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueUrlGenerator\MediaValueUrlGenerator::__construct
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueUrlGenerator\MediaValueUrlGenerator::generate
     */
    public function testGenerate(): void
    {
        $this->urlGeneratorMock
            ->expects(self::once())
            ->method('generate')
            ->with(
                self::identicalTo('bitbag_sylius_cms_plugin_admin_media_update'),
                self::identicalTo(['id' => 42]),
            )
            ->willReturn('/media/42/edit');

        self::assertSame(
            '/media/42/edit',
            $this->urlGenerator->generate(new Media(42, 'logo-image', 'Logo')),
        );
    }
}