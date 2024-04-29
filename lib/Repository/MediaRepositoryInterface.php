<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Repository;

use BitBag\SyliusCmsPlugin\Repository\MediaRepositoryInterface as BaseMediaRepositoryInterface;
use Pagerfanta\PagerfantaInterface;

interface MediaRepositoryInterface extends BaseMediaRepositoryInterface
{
    /**
     * Creates a paginator which is used to list medias.
     *
     * @return \Pagerfanta\PagerfantaInterface<\BitBag\SyliusCmsPlugin\Entity\Media>
     */
    public function createListPaginator(string $localeCode): PagerfantaInterface;

    /**
     * Creates a paginator which is used to search for medias.
     *
     * @return \Pagerfanta\PagerfantaInterface<\BitBag\SyliusCmsPlugin\Entity\Media>
     */
    public function createSearchPaginator(string $searchText, string $localeCode): PagerfantaInterface;
}
