<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Repository;

use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface as BasePageRepositoryInterface;
use Pagerfanta\PagerfantaInterface;

interface PageRepositoryInterface extends BasePageRepositoryInterface
{
    /**
     * Creates a paginator which is used to list pages.
     *
     * @return \Pagerfanta\PagerfantaInterface<\BitBag\SyliusCmsPlugin\Entity\Page>
     */
    public function createListPaginator(string $localeCode): PagerfantaInterface;

    /**
     * Creates a paginator which is used to search for pages.
     *
     * @return \Pagerfanta\PagerfantaInterface<\BitBag\SyliusCmsPlugin\Entity\Page>
     */
    public function createSearchPaginator(string $searchText, string $localeCode): PagerfantaInterface;
}
