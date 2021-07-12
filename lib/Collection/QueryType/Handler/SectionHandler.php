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
use const PHP_INT_MAX;

final class SectionHandler implements QueryTypeHandlerInterface
{
    use BitBagSortingTrait;
    use SyliusChannelFilterTrait;

    private SectionRepositoryInterface $sectionRepository;

    private LocaleContextInterface $localeContext;

    /** @var array<string, string> */
    private array $sortingOptions = [
        'Name' => 'translations.name',
        'Code' => 'code',
    ];

    public function __construct(
        SectionRepositoryInterface $sectionRepository,
        LocaleContextInterface $localeContext
    ) {
        $this->sectionRepository = $sectionRepository;
        $this->localeContext = $localeContext;
    }

    public function buildParameters(ParameterBuilderInterface $builder): void
    {
        $advancedGroup = [self::GROUP_ADVANCED];

        $this->buildSyliusChannelFilterParameters($builder, $advancedGroup);
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

        $limit = $limit ?? PHP_INT_MAX;

        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage((int) ($offset / $limit) + 1);

        return $paginator->getCurrentPageResults();
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
