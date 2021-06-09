<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsSyliusBitBagBundle\Templating\Twig\Runtime;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use Netgen\Layouts\Sylius\BitBag\Repository\PageRepositoryInterface;

final class BitBagRuntime
{
    private PageRepositoryInterface $pageRepository;

    public function __construct(
        PageRepositoryInterface $pageRepository
    ) {
        $this->pageRepository = $pageRepository;
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
}
