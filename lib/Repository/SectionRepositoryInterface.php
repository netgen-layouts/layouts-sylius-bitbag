<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Repository;

use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface as BaseSectionRepositoryInterface;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\PagerfantaInterface;

interface SectionRepositoryInterface extends BaseSectionRepositoryInterface
{
    /**
     * Creates a paginator which is used to list sections.
     */
    public function createListPaginator(string $localeCode): PagerfantaInterface;

    /**
     * Creates a paginator which is used to filter sections.
     */
    public function createFilterPaginator(QueryBuilder $queryBuilder): PagerfantaInterface;

    /**
     * Creates a paginator which is used to search for sections.
     */
    public function createSearchPaginator(string $searchText, string $localeCode): PagerfantaInterface;
}
