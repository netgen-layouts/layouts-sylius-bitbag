<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Layout\Resolver\TargetHandler\Doctrine;

use Netgen\Layouts\Persistence\Doctrine\QueryHandler\TargetHandlerInterface;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\DBAL\Types\Types;

class Section implements TargetHandlerInterface
{
    public function handleQuery(QueryBuilder $query, $value): void
    {
        $query->andWhere(
            $query->expr()->eq('rt.value', ':target_value'),
        )
        ->setParameter('target_value', $value, Types::INTEGER);
    }
}
