<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Repository;

use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface as BasePageRepositoryInterface;
use Pagerfanta\PagerfantaInterface;

interface PageRepositoryInterface extends BasePageRepositoryInterface
{
    /**
     * Creates a paginator which is used to filter pages.
     */
    public function createListPaginator(string $localeCode): PagerfantaInterface;

    /**
     * Creates a paginator which is used to search for pages.
     */
    public function createSearchPaginator(string $searchText, string $localeCode): PagerfantaInterface;
}
