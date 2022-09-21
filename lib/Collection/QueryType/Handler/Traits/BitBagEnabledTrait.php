<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits;

use Doctrine\ORM\QueryBuilder;

use function count;

trait BitBagEnabledTrait
{
    /**
     * Builds the criteria for filtering only enabled entities.
     */
    private function addBitBagEnabledCriterion(QueryBuilder $queryBuilder): void
    {
        $field = count($queryBuilder->getRootAliases()) > 0
            ? $queryBuilder->getRootAliases()[0] . '.enabled'
            : 'enabled';

        $queryBuilder->andWhere($queryBuilder->expr()->eq($field, true));
    }
}
