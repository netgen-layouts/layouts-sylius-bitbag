<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsSyliusBitBagBundle\Templating\Twig\Runtime;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use Netgen\Layouts\Sylius\BitBag\Repository\PageRepositoryInterface;
use Netgen\Layouts\Sylius\BitBag\Repository\SectionRepositoryInterface;

final class BitBagRuntime
{
    public function __construct(
        private PageRepositoryInterface $pageRepository,
        private SectionRepositoryInterface $sectionRepository,
    ) {}

    public function getPageName(int|string $pageId): ?string
    {
        $page = $this->pageRepository->find($pageId);
        if (!$page instanceof PageInterface) {
            return null;
        }

        return $page->getName();
    }

    public function getSectionName(int|string $sectionId): ?string
    {
        $section = $this->sectionRepository->find($sectionId);
        if (!$section instanceof SectionInterface) {
            return null;
        }

        return $section->getName();
    }
}
