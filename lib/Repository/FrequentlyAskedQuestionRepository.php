<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Repository;

use BitBag\SyliusCmsPlugin\Repository\FrequentlyAskedQuestionRepository as BaseFrequentlyAskedQuestionRepository;
use Doctrine\ORM\QueryBuilder;
use Pagerfanta\PagerfantaInterface;

final class FrequentlyAskedQuestionRepository extends BaseFrequentlyAskedQuestionRepository implements FrequentlyAskedQuestionRepositoryInterface
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
                    'translation.question LIKE :search',
                    'translation.answer LIKE :search',
                ),
            )
            ->setParameter('search', '%' . $searchText . '%');

        return $this->getPaginator($queryBuilder);
    }
}
