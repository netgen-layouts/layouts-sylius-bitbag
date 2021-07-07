<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Repository;

use BitBag\SyliusCmsPlugin\Repository\BlockRepositoryInterface as BaseBlockRepositoryInterface;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\PagerfantaInterface;

interface BlockRepositoryInterface extends BaseBlockRepositoryInterface
{
    /**
     * Creates a paginator which is used to list blocks.
     */
    public function createListPaginator(string $localeCode): PagerfantaInterface;

    /**
     * Creates a paginator which is used to filter blocks.
     */
    public function createFilterPaginator(QueryBuilder $queryBuilder): PagerfantaInterface;

    /**
     * Creates a paginator which is used to search for blocks.
     */
    public function createSearchPaginator(string $searchText, string $localeCode): PagerfantaInterface;
}
