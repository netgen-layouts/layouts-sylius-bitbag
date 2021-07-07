<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler;

use Netgen\Layouts\API\Values\Collection\Query;
use Netgen\Layouts\Collection\QueryType\QueryTypeHandlerInterface;
use Netgen\Layouts\Parameters\ParameterBuilderInterface;
use Netgen\Layouts\Parameters\ParameterType;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\SyliusChannelFilterTrait;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\SyliusProductTrait;
use Netgen\Layouts\Sylius\BitBag\Repository\PageRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class PageHandler implements QueryTypeHandlerInterface
{
    use SyliusProductTrait;

    private PageRepositoryInterface $pageRepository;

    private LocaleContextInterface $localeContext;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        LocaleContextInterface $localeContext
    ) {
        $this->pageRepository = $pageRepository;
        $this->localeContext = $localeContext;
    }

    public function buildParameters(ParameterBuilderInterface $builder): void
    {
        $this->buildSyliusProductParameters($builder);
    }

    public function getValues(Query $query, int $offset = 0, ?int $limit = null): iterable
    {
        $queryBuilder = $this->pageRepository->createListQueryBuilder(
            $this->localeContext->getLocaleCode(),
        );

        $this->addSyliusProductCriterion($query, $queryBuilder);

        $paginator = $this->pageRepository->createFilterPaginator($queryBuilder);
        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage((int) ($offset / $limit) + 1);

        return $paginator->getCurrentPageResults();
    }

    public function getCount(Query $query): int
    {
        $queryBuilder = $this->pageRepository->createListQueryBuilder(
            $this->localeContext->getLocaleCode(),
        );

        $this->addSyliusProductCriterion($query, $queryBuilder);

        $paginator = $this->pageRepository->createFilterPaginator($queryBuilder);

        return $paginator->getNbResults();
    }

    public function isContextual(Query $query): bool
    {
        return $this->isSyliusProductContextual($query);
    }
}
