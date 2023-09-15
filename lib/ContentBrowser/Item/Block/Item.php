<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Block;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface as BitBagBlockInterface;
use Netgen\ContentBrowser\Item\ItemInterface;

final class Item implements ItemInterface, BlockInterface
{
    public function __construct(private BitBagBlockInterface $block) {}

    public function getValue(): int
    {
        return $this->block->getId();
    }

    public function getName(): string
    {
        return (string) $this->block->getName();
    }

    public function isVisible(): bool
    {
        return true;
    }

    public function isSelectable(): bool
    {
        return true;
    }

    public function getBlock(): BitBagBlockInterface
    {
        return $this->block;
    }
}
