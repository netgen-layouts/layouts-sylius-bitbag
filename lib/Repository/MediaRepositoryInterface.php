<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Repository;

use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface as BaseMediaRepositoryInterface;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\PagerfantaInterface;

interface MediaRepositoryInterface extends BaseMediaRepositoryInterface
{
    /**
     * Creates a paginator which is used to list medias.
     */
    public function createListPaginator(string $localeCode): PagerfantaInterface;

    /**
     * Creates a paginator which is used to filter media.
     */
    public function createFilterPaginator(QueryBuilder $queryBuilder): PagerfantaInterface;

    /**
     * Creates a paginator which is used to search for medias.
     */
    public function createSearchPaginator(string $searchText, string $localeCode): PagerfantaInterface;
}
