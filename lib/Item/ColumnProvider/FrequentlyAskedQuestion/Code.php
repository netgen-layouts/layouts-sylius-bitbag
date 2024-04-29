<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Item\ColumnProvider\FrequentlyAskedQuestion;

use Netgen\ContentBrowser\Item\ColumnProvider\ColumnValueProviderInterface;
use Netgen\ContentBrowser\Item\ItemInterface;
use Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\FrequentlyAskedQuestion\FrequentlyAskedQuestionInterface;

final class Code implements ColumnValueProviderInterface
{
    public function getValue(ItemInterface $item): ?string
    {
        if (!$item instanceof FrequentlyAskedQuestionInterface) {
            return null;
        }

        return $item->getFrequentlyAskedQuestion()->getCode();
    }
}
