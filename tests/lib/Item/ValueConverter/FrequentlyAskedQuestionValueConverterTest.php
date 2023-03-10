<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\ValueConverter;

use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestion;
use BitBag\SyliusCmsPlugin\Entity\Section;
use Netgen\Layouts\Sylius\BitBag\Item\ValueConverter\FrequentlyAskedQuestionValueConverter;
use Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs\FrequentlyAskedQuestion as FrequentlyAskedQuestionStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(FrequentlyAskedQuestionValueConverter::class)]
final class FrequentlyAskedQuestionValueConverterTest extends TestCase
{
    private FrequentlyAskedQuestionValueConverter $valueConverter;

    protected function setUp(): void
    {
        $this->valueConverter = new FrequentlyAskedQuestionValueConverter();
    }

    public function testSupports(): void
    {
        self::assertTrue($this->valueConverter->supports(new FrequentlyAskedQuestion()));
        self::assertFalse($this->valueConverter->supports(new Section()));
    }

    public function testGetValueType(): void
    {
        self::assertSame(
            'bitbag_frequently_asked_question',
            $this->valueConverter->getValueType(
                new FrequentlyAskedQuestion(),
            ),
        );
    }

    public function testGetId(): void
    {
        self::assertSame(
            42,
            $this->valueConverter->getId(
                new FrequentlyAskedQuestionStub(42, 'TEST_QUESTION'),
            ),
        );
    }

    public function testGetRemoteId(): void
    {
        self::assertSame(
            42,
            $this->valueConverter->getRemoteId(
                new FrequentlyAskedQuestionStub(42, 'TEST_QUESTION'),
            ),
        );
    }

    public function testGetName(): void
    {
        self::assertSame(
            'What is this?',
            $this->valueConverter->getName(
                new FrequentlyAskedQuestionStub(42, 'TEST_QUESTION', 'What is this?'),
            ),
        );
    }

    public function testGetIsVisible(): void
    {
        self::assertTrue(
            $this->valueConverter->getIsVisible(
                new FrequentlyAskedQuestionStub(42, 'TEST_QUESTION'),
            ),
        );

        self::assertFalse(
            $this->valueConverter->getIsVisible(
                new FrequentlyAskedQuestionStub(42, 'TEST_QUESTION', null, null, false),
            ),
        );
    }

    public function testGetObject(): void
    {
        $frequentlyAskedQueston = new FrequentlyAskedQuestionStub(42, 'TEST_QUESTION');

        self::assertSame($frequentlyAskedQueston, $this->valueConverter->getObject($frequentlyAskedQueston));
    }
}
