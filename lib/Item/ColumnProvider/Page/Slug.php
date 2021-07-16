<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Item\ColumnProvider\Page;

use Netgen\ContentBrowser\Item\ColumnProvider\ColumnValueProviderInterface;
use Netgen\ContentBrowser\Item\ItemInterface;
use Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Page\PageInterface;

class Slug implements ColumnValueProviderInterface
{
    public function getValue(Iteminterface $item): ?string
    {
        if (!$item instanceof PageInterface) {
            return null;
        }

        return $item->getPage()->getSlug();
    }
}
