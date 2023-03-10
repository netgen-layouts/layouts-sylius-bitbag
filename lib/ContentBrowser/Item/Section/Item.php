<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Section;

use BitBag\SyliusCmsPlugin\Entity\SectionInterface as BitBagSectionInterface;
use Netgen\ContentBrowser\Item\ItemInterface;

final class Item implements ItemInterface, SectionInterface
{
    public function __construct(private BitBagSectionInterface $section)
    {
    }

    public function getValue(): int
    {
        return $this->section->getId();
    }

    public function getName(): string
    {
        return (string) $this->section->getName();
    }

    public function isVisible(): bool
    {
        return true;
    }

    public function isSelectable(): bool
    {
        return true;
    }

    public function getSection(): BitBagSectionInterface
    {
        return $this->section;
    }
}
