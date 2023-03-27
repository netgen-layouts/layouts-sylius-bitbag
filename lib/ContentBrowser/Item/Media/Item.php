<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Media;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface as BitBagMediaInterface;
use Netgen\ContentBrowser\Item\ItemInterface;

final class Item implements ItemInterface, MediaInterface
{
    private BitBagMediaInterface $media;

    public function __construct(BitBagMediaInterface $media)
    {
        $this->media = $media;
    }

    public function getValue(): int
    {
        return $this->media->getId();
    }

    public function getName(): string
    {
        return (string) ($this->media->getName() ?? $this->media->getCode());
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
