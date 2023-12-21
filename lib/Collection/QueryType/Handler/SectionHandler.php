<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler;

use Netgen\Layouts\API\Values\Collection\Query;
use Netgen\Layouts\Collection\QueryType\QueryTypeHandlerInterface;
use Netgen\Layouts\Parameters\ParameterBuilderInterface;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\BitBagSortingTrait;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\SyliusChannelFilterTrait;
use Netgen\Layouts\Sylius\BitBag\Repository\SectionRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

use function max;

use const PHP_INT_MAX;

final class SectionHandler implements QueryTypeHandlerInterface
{
    use BitBagSortingTrait;
    use SyliusChannelFilterTrait;

    /** @var array<string, string> */
    private array $sortingOptions = [
        'Name' => 'translations.name',
        'Code' => 'code',
    ];

    public function __construct(
        private SectionRepositoryInterface $sectionRepository,
        private LocaleContextInterface $localeContext,
    ) {}

    public function buildParameters(ParameterBuilderInterface $builder): void
    {
        $this->buildSyliusChannelFilterParameters($builder);
        $this->buildBitBagSortingParameters($builder, $this->sortingOptions);
    }

    public function getValues(Query $query, int $offset = 0, ?int $limit = null): iterable
    {
        $queryBuilder = $this->sectionRepository->createListQueryBuilder(
            $this->localeContext->getLocaleCode(),
        );

        $this->addSyliusChannelFilterCriterion($query, $queryBuilder);
        $this->addBitBagSortingClause($query, $queryBuilder);

        $paginator = $this->sectionRepository->createFilterPaginator($queryBuilder);

        $limit = $limit === null ? PHP_INT_MAX : max(0, $limit);
        $offset = max(0, $offset);

        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage((int) ($offset / $limit) + 1);

        return $paginator->getAdapter()->getSlice($offset, $limit);
    }

    public function getCount(Query $query): int
    {
        $queryBuilder = $this->sectionRepository->createListQueryBuilder(
            $this->localeContext->getLocaleCode(),
        );

        $this->addSyliusChannelFilterCriterion($query, $queryBuilder);

        $paginator = $this->sectionRepository->createFilterPaginator($queryBuilder);

        return $paginator->getNbResults();
    }

    public function isContextual(Query $query): bool
    {
        return false;
    }
}
