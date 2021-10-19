<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\ContentBrowser\Item\FrequentlyAskedQuestion;

use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\FrequentlyAskedQuestion\Item;
use Netgen\Layouts\Sylius\BitBag\Tests\Stubs\FrequentlyAskedQuestion;
use PHPUnit\Framework\TestCase;

final class ItemTest extends TestCase
{
    private FrequentlyAskedQuestionInterface $frequentlyAskedQuestion;

    private Item $item;

    protected function setUp(): void
    {
        $this->frequentlyAskedQuestion = new FrequentlyAskedQuestion(42, 'TEST_QUESTION');
        $this->frequentlyAskedQuestion->setCurrentLocale('en');
        $this->frequentlyAskedQuestion->setFallbackLocale('en');
        $this->frequentlyAskedQuestion->setQuestion('What is this?');
        $this->frequentlyAskedQuestion->setAnswer('This is a test.');

        $this->item = new Item($this->frequentlyAskedQuestion);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\FrequentlyAskedQuestion\Item::__construct
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\FrequentlyAskedQuestion\Item::getValue
     */
    public function testGetValue(): void
    {
        self::assertSame(42, $this->item->getValue());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\FrequentlyAskedQuestion\Item::getName
     */
    public function testGetName(): void
    {
        self::assertSame('What is this?', $this->item->getName());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\FrequentlyAskedQuestion\Item::isVisible
     */
    public function testIsVisible(): void
    {
        self::assertTrue($this->item->isVisible());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\FrequentlyAskedQuestion\Item::isSelectable
     */
    public function testIsSelectable(): void
    {
        self::assertTrue($this->item->isSelectable());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\FrequentlyAskedQuestion\Item::getFrequentlyAskedQuestion
     */
    public function testGetFrequentlyAskedQuestion(): void
    {
        self::assertSame($this->frequentlyAskedQuestion, $this->item->getFrequentlyAskedQuestion());
    }
}
