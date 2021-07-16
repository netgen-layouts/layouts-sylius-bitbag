<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Item\ColumnProvider\Section;

use Netgen\ContentBrowser\Item\ColumnProvider\ColumnValueProviderInterface;
use Netgen\ContentBrowser\Item\ItemInterface;
use Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Section\SectionInterface;

class Code implements ColumnValueProviderInterface
{
    public function getValue(Iteminterface $item): ?string
    {
        if (!$item instanceof SectionInterface) {
            return null;
        }

        return $item->getSection()->getCode();
    }
}
