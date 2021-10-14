<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\ValueUrlGenerator;

use Netgen\Layouts\Sylius\BitBag\Item\ValueUrlGenerator\FrequentlyAskedQuestionValueUrlGenerator;
use Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs\FrequentlyAskedQuestion;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class FrequentlyAskedQuestionValueUrlGeneratorTest extends TestCase
{
    private MockObject $urlGeneratorMock;

    private FrequentlyAskedQuestionValueUrlGenerator $urlGenerator;

    protected function setUp(): void
    {
        $this->urlGeneratorMock = $this->createMock(UrlGeneratorInterface::class);

        $this->urlGenerator = new FrequentlyAskedQuestionValueUrlGenerator($this->urlGeneratorMock);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueUrlGenerator\FrequentlyAskedQuestionValueUrlGenerator::__construct
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueUrlGenerator\FrequentlyAskedQuestionValueUrlGenerator::generate
     */
    public function testGenerate(): void
    {
        $this->urlGeneratorMock
            ->expects(self::once())
            ->method('generate')
            ->with(
                self::identicalTo('bitbag_sylius_cms_plugin_admin_frequently_asked_question_update'),
                self::identicalTo(['id' => 42]),
            )
            ->willReturn('/faq/42/edit');

        self::assertSame(
            '/faq/42/edit',
            $this->urlGenerator->generate(new FrequentlyAskedQuestion(42, 'TEST_QUESTION')),
        );
    }
}
