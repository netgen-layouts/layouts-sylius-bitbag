<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\FrequentlyAskedQuestion;

use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestionInterface as BitBagFrequentlyAskedQuestionInterface;
use Netgen\ContentBrowser\Item\ItemInterface;

final class Item implements ItemInterface, FrequentlyAskedQuestionInterface
{
    public function __construct(private BitBagFrequentlyAskedQuestionInterface $frequentlyAskedQuestion) {}

    public function getValue(): int
    {
        return $this->frequentlyAskedQuestion->getId();
    }

    public function getName(): string
    {
        return (string) $this->frequentlyAskedQuestion->getQuestion();
    }

    public function isVisible(): bool
    {
        return true;
    }

    public function isSelectable(): bool
    {
        return true;
    }

    public function getFrequentlyAskedQuestion(): BitBagFrequentlyAskedQuestionInterface
    {
        return $this->frequentlyAskedQuestion;
    }
}
