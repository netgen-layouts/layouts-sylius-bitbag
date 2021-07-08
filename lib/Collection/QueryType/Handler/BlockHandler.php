<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler;

use Netgen\Layouts\API\Values\Collection\Query;
use Netgen\Layouts\Collection\QueryType\QueryTypeHandlerInterface;
use Netgen\Layouts\Parameters\ParameterBuilderInterface;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\SyliusChannelFilterTrait;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\SyliusProductTrait;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\SyliusTaxonTrait;
use Netgen\Layouts\Sylius\BitBag\Repository\BlockRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use const PHP_INT_MAX;

final class BlockHandler implements QueryTypeHandlerInterface
{
    use SyliusChannelFilterTrait;
    use SyliusProductTrait;
    use SyliusTaxonTrait;

    private BlockRepositoryInterface $blockRepository;

    private LocaleContextInterface $localeContext;

    private RequestStack $requestStack;

    public function __construct(
        BlockRepositoryInterface $blockRepository,
        LocaleContextInterface $localeContext,
        RequestStack $requestStack
    ) {
        $this->blockRepository = $blockRepository;
        $this->localeContext = $localeContext;
        $this->requestStack = $requestStack;
    }

    public function buildParameters(ParameterBuilderInterface $builder): void
    {
        $advancedGroup = [self::GROUP_ADVANCED];

        $this->buildSyliusProductParameters($builder);
        $this->buildSyliusTaxonParameters($builder);
        $this->buildSyliusChannelFilterParameters($builder, $advancedGroup);
    }

    public function getValues(Query $query, int $offset = 0, ?int $limit = null): iterable
    {
        $queryBuilder = $this->blockRepository->createListQueryBuilder(
            $this->localeContext->getLocaleCode(),
        );

        $request = $this->requestStack->getCurrentRequest();

        $this->addSyliusProductCriterion($query, $queryBuilder, $request);
        $this->addSyliusTaxonCriterion($query, $queryBuilder, $request);
        $this->addSyliusChannelFilterCriterion($query, $queryBuilder);

        $paginator = $this->blockRepository->createFilterPaginator($queryBuilder);

        $limit = $limit ?? PHP_INT_MAX;

        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage((int) ($offset / $limit) + 1);

        return $paginator->getCurrentPageResults();
    }

    public function getCount(Query $query): int
    {
        $queryBuilder = $this->blockRepository->createListQueryBuilder(
            $this->localeContext->getLocaleCode(),
        );

        $request = $this->requestStack->getCurrentRequest();

        $this->addSyliusProductCriterion($query, $queryBuilder, $request);
        $this->addSyliusTaxonCriterion($query, $queryBuilder, $request);
        $this->addSyliusChannelFilterCriterion($query, $queryBuilder);

        $paginator = $this->blockRepository->createFilterPaginator($queryBuilder);

        return $paginator->getNbResults();
    }

    public function isContextual(Query $query): bool
    {
        return $this->isSyliusProductContextual($query)
            || $this->isSyliusTaxonContextual($query);
    }
}
