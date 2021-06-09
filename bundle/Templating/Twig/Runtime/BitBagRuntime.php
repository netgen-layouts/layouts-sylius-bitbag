<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsSyliusBitBagBundle\Templating\Twig\Runtime;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use Netgen\Layouts\Sylius\BitBag\Repository\PageRepositoryInterface;
use Netgen\Layouts\Sylius\BitBag\Repository\SectionRepositoryInterface;

final class BitBagRuntime
{
    private PageRepositoryInterface $pageRepository;

    private SectionRepositoryInterface $sectionRepository;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        SectionRepositoryInterface $sectionRepository
    ) {
        $this->pageRepository = $pageRepository;
        $this->sectionRepository = $sectionRepository;
    }

    /**
     * @param int|string $pageId
     */
    public function getPageName($pageId): ?string
    {
        $page = $this->pageRepository->find($pageId);
        if (!$page instanceof PageInterface) {
            return null;
        }

        return $page->getName();
    }

    /**
     * @param int|string $sectionId
     */
    public function getSectionName($sectionId): ?string
    {
        $section = $this->sectionRepository->find($sectionId);
        if (!$section instanceof SectionInterface) {
            return null;
        }

        return $section->getName();
    }
}
