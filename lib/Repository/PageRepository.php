<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Repository;

use BitBag\SyliusCmsPlugin\Repository\PageRepository as BasePageRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\PagerfantaInterface;

final class PageRepository extends BasePageRepository implements PageRepositoryInterface
{
    public function createListPaginator(string $localeCode): PagerfantaInterface
    {
        $queryBuilder = $this->createListQueryBuilder($localeCode);

        return $this->getPaginator($queryBuilder);
    }

    public function createSearchPaginator(string $searchText, string $localeCode): PagerfantaInterface
    {
        $queryBuilder = $this->createListQueryBuilder($localeCode);
        $queryBuilder
            ->andWhere(
                $queryBuilder->expr()->orX(
                    'o.code LIKE :search',
                    'translation.name LIKE :search',
                    'translation.title LIKE :search',
                    'translation.content LIKE :search',
                ),
            )
            ->setParameter('search', '%' . $searchText . '%');

        return $this->getPaginator($queryBuilder);
    }
}
