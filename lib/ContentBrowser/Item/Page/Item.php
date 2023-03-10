<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Page;

use BitBag\SyliusCmsPlugin\Entity\PageInterface as BitBagPageInterface;
use Netgen\ContentBrowser\Item\ItemInterface;

final class Item implements ItemInterface, PageInterface
{
    public function __construct(private BitBagPageInterface $page)
    {
    }

    public function getValue(): int
    {
        return $this->page->getId();
    }

    public function getName(): string
    {
        return (string) $this->page->getName();
    }

    public function isVisible(): bool
    {
        return true;
    }

    public function isSelectable(): bool
    {
        return true;
    }

    public function getPage(): BitBagPageInterface
    {
        return $this->page;
    }
}
