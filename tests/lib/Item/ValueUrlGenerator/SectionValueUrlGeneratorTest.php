<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\ValueUrlGenerator;

use Netgen\Layouts\Sylius\BitBag\Item\ValueUrlGenerator\SectionValueUrlGenerator;
use Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs\Section;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

#[CoversClass(SectionValueUrlGenerator::class)]
final class SectionValueUrlGeneratorTest extends TestCase
{
    private MockObject&UrlGeneratorInterface $urlGeneratorMock;

    private SectionValueUrlGenerator $urlGenerator;

    protected function setUp(): void
    {
        $this->urlGeneratorMock = $this->createMock(UrlGeneratorInterface::class);

        $this->urlGenerator = new SectionValueUrlGenerator($this->urlGeneratorMock);
    }

    public function testGenerate(): void
    {
        $this->urlGeneratorMock
            ->expects(self::once())
            ->method('generate')
            ->with(
                self::identicalTo('bitbag_sylius_cms_plugin_admin_section_update'),
                self::identicalTo(['id' => 42]),
            )
            ->willReturn('/sections/42/edit');

        self::assertSame(
            '/sections/42/edit',
            $this->urlGenerator->generate(new Section(42, 'blog', 'Blog')),
        );
    }
}
