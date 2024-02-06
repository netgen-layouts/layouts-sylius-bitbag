<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Repository;

use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface as BaseBlockRepositoryInterface;
use Pagerfanta\PagerfantaInterface;

interface BlockRepositoryInterface extends BaseBlockRepositoryInterface
{
    /**
     * Creates a paginator which is used to list blocks.
     *
     * @return \Pagerfanta\PagerfantaInterface<\BitBag\SyliusCmsPlugin\Entity\Block>
     */
    public function createListPaginator(string $localeCode): PagerfantaInterface;

    /**
     * Creates a paginator which is used to search for blocks.
     *
     * @return \Pagerfanta\PagerfantaInterface<\BitBag\SyliusCmsPlugin\Entity\Block>
     */
    public function createSearchPaginator(string $searchText, string $localeCode): PagerfantaInterface;
}
