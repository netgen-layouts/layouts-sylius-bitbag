<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Item\ValueLoader;

use BitBag\SyliusCmsPlugin\Entity\PageInterface;
use Netgen\Layouts\Item\ValueLoaderInterface;
use Netgen\Layouts\Sylius\BitBag\Repository\PageRepositoryInterface;
use Throwable;

final class PageValueLoader implements ValueLoaderInterface
{
    private PageRepositoryInterface $pageRepository;

    public function __construct(PageRepositoryInterface $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    public function load($id): ?PageInterface
    {
        try {
            $page = $this->pageRepository->find($id);
        } catch (Throwable $t) {
            return null;
        }

        return $page instanceof PageInterface ? $page : null;
    }

    public function loadByRemoteId($remoteId): ?PageInterface
    {
        return $this->load($remoteId);
    }
}
