<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Media;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface as BitBagMediaInterface;
use Netgen\ContentBrowser\Item\ItemInterface;

final class Item implements ItemInterface, MediaInterface
{
    public function __construct(private BitBagMediaInterface $media) {}

    public function getValue(): int
    {
        return $this->media->getId();
    }

    public function getName(): string
    {
        return $this->media->getName() ?? $this->media->getCode() ?? '';
    }

    public function isVisible(): bool
    {
        return true;
    }

    public function isSelectable(): bool
    {
        return true;
    }

    public function getMedia(): BitBagMediaInterface
    {
        return $this->media;
    }
}
