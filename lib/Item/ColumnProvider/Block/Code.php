<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Item\ColumnProvider\Block;

use Netgen\ContentBrowser\Item\ColumnProvider\ColumnValueProviderInterface;
use Netgen\ContentBrowser\Item\ItemInterface;
use Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Block\BlockInterface;

final class Code implements ColumnValueProviderInterface
{
    public function getValue(Iteminterface $item): ?string
    {
        if (!$item instanceof BlockInterface) {
            return null;
        }

        return $item->getBlock()->getCode();
    }
}
