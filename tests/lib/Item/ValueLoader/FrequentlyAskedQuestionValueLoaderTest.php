<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\ValueLoader;

use Exception;
use Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\FrequentlyAskedQuestionValueLoader;
use Netgen\Layouts\Sylius\BitBag\Repository\FrequentlyAskedQuestionRepositoryInterface;
use Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs\FrequentlyAskedQuestion;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class FrequentlyAskedQuestionValueLoaderTest extends TestCase
{
    private MockObject&FrequentlyAskedQuestionRepositoryInterface $frequentlyAskedQuestionRepositoryMock;

    private FrequentlyAskedQuestionValueLoader $valueLoader;

    protected function setUp(): void
    {
        $this->frequentlyAskedQuestionRepositoryMock = $this->createMock(FrequentlyAskedQuestionRepositoryInterface::class);
        $this->valueLoader = new FrequentlyAskedQuestionValueLoader($this->frequentlyAskedQuestionRepositoryMock);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\FrequentlyAskedQuestionValueLoader::__construct
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\FrequentlyAskedQuestionValueLoader::load
     */
    public function testLoad(): void
    {
        $frequentlyAskedQuestion = new FrequentlyAskedQuestion(42, 'TEST_QUESTION');

        $this->frequentlyAskedQuestionRepositoryMock
            ->expects(self::any())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn($frequentlyAskedQuestion);

        self::assertSame($frequentlyAskedQuestion, $this->valueLoader->load(42));
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\FrequentlyAskedQuestionValueLoader::load
     */
    public function testLoadWithNoFrequentlyAskedQuestion(): void
    {
        $this->frequentlyAskedQuestionRepositoryMock
            ->expects(self::any())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn(null);

        self::assertNull($this->valueLoader->load(42));
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\FrequentlyAskedQuestionValueLoader::load
     */
    public function testLoadWithRepositoryException(): void
    {
        $this->frequentlyAskedQuestionRepositoryMock
            ->expects(self::any())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willThrowException(new Exception());

        self::assertNull($this->valueLoader->load(42));
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\FrequentlyAskedQuestionValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteId(): void
    {
        $frequentlyAskedQuestion = new FrequentlyAskedQuestion(42, 'TEST_QUESTION');

        $this->frequentlyAskedQuestionRepositoryMock
            ->expects(self::any())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn($frequentlyAskedQuestion);

        self::assertSame($frequentlyAskedQuestion, $this->valueLoader->loadByRemoteId(42));
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\FrequentlyAskedQuestionValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteIdWithNoFrequentlyAskedQuestion(): void
    {
        $this->frequentlyAskedQuestionRepositoryMock
            ->expects(self::any())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn(null);

        self::assertNull($this->valueLoader->loadByRemoteId(42));
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Item\ValueLoader\FrequentlyAskedQuestionValueLoader::loadByRemoteId
     */
    public function testLoadByRemoteIdWithRepositoryException(): void
    {
        $this->frequentlyAskedQuestionRepositoryMock
            ->expects(self::any())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willThrowException(new Exception());

        self::assertNull($this->valueLoader->loadByRemoteId(42));
    }
}
