<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Repository;

use BitBag\SyliusCmsPlugin\Repository\FrequentlyAskedQuestionRepositoryInterface as BaseFrequentlyAskedQuestionRepositoryInterface;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\PagerfantaInterface;

interface FrequentlyAskedQuestionRepositoryInterface extends BaseFrequentlyAskedQuestionRepositoryInterface
{
    /**
     * Creates a paginator which is used to list frequently asked questions.
     */
    public function createListPaginator(string $localeCode): PagerfantaInterface;

    /**
     * Creates a paginator which is used to filter frequently asked questions.
     */
    public function createFilterPaginator(QueryBuilder $queryBuilder): PagerfantaInterface;

    /**
     * Creates a paginator which is used to search for frequently asked questions.
     */
    public function createSearchPaginator(string $searchText, string $localeCode): PagerfantaInterface;
}
