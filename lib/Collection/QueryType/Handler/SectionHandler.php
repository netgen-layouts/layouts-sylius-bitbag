<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler;

use Netgen\Layouts\API\Values\Collection\Query;
use Netgen\Layouts\Collection\QueryType\QueryTypeHandlerInterface;
use Netgen\Layouts\Parameters\ParameterBuilderInterface;
use Netgen\Layouts\Parameters\ParameterType;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\SyliusChannelFilterTrait;
use Netgen\Layouts\Sylius\BitBag\Repository\SectionRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class SectionHandler implements QueryTypeHandlerInterface
{
    use SyliusChannelFilterTrait;

    private SectionRepositoryInterface $sectionRepository;

    private LocaleContextInterface $localeContext;

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
    }

    public function getValues(Query $query, int $offset = 0, ?int $limit = null): iterable
    {
        $queryBuilder = $this->sectionRepository->createListQueryBuilder(
            $this->localeContext->getLocaleCode(),
        );

        $this->addSyliusChannelFilterCriterion($query, $queryBuilder);

        $paginator = $this->sectionRepository->createFilterPaginator($queryBuilder);
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
