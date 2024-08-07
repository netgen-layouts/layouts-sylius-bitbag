<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Item\ColumnProvider\Media;

use Netgen\ContentBrowser\Item\ColumnProvider\ColumnValueProviderInterface;
use Netgen\ContentBrowser\Item\ItemInterface;
use Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Media\MediaInterface;

final class Type implements ColumnValueProviderInterface
{
    public function getValue(ItemInterface $item): ?string
    {
        if (!$item instanceof MediaInterface) {
            return null;
        }

        return $item->getMedia()->getType();
    }
}
