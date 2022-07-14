<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler;

use Netgen\Layouts\API\Values\Collection\Query;
use Netgen\Layouts\Collection\QueryType\QueryTypeHandlerInterface;
use Netgen\Layouts\Parameters\ParameterBuilderInterface;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\BitBagSectionTrait;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\BitBagSortingTrait;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\SyliusChannelFilterTrait;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\SyliusProductTrait;
use Netgen\Layouts\Sylius\BitBag\Repository\MediaRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;

use const PHP_INT_MAX;

final class MediaHandler implements QueryTypeHandlerInterface
{
    use BitBagSectionTrait;
    use BitBagSortingTrait;
    use SyliusChannelFilterTrait;
    use SyliusProductTrait;

    private MediaRepositoryInterface $mediaRepository;

    private LocaleContextInterface $localeContext;

    private RequestStack $requestStack;

    /** @var array<string, string> */
    private array $sortingOptions = [
        'Name' => 'translations.name',
        'Code' => 'code',
    ];

    public function __construct(
        MediaRepositoryInterface $mediaRepository,
        LocaleContextInterface $localeContext,
        RequestStack $requestStack
    ) {
        $this->mediaRepository = $mediaRepository;
        $this->localeContext = $localeContext;
        $this->requestStack = $requestStack;
    }

    public function buildParameters(ParameterBuilderInterface $builder): void
    {
        $this->buildSyliusProductParameters($builder);
        $this->buildBitBagSectionParameters($builder);
        $this->buildSyliusChannelFilterParameters($builder);
        $this->buildBitBagSortingParameters($builder, $this->sortingOptions);
    }

    public function getValues(Query $query, int $offset = 0, ?int $limit = null): iterable
    {
        $queryBuilder = $this->mediaRepository->createListQueryBuilder(
            $this->localeContext->getLocaleCode(),
        );

        $request = $this->requestStack->getCurrentRequest();

        $this->addSyliusProductCriterion($query, $queryBuilder, $request);
        $this->addBitBagSectionCriterion($query, $queryBuilder, $request);
        $this->addSyliusChannelFilterCriterion($query, $queryBuilder);
        $this->addBitBagSortingClause($query, $queryBuilder);

        $paginator = $this->mediaRepository->createFilterPaginator($queryBuilder);

        $limit = $limit ?? PHP_INT_MAX;

        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage((int) ($offset / $limit) + 1);

        return $paginator->getCurrentPageResults();
    }

    public function getCount(Query $query): int
    {
        $queryBuilder = $this->mediaRepository->createListQueryBuilder(
            $this->localeContext->getLocaleCode(),
        );

        $request = $this->requestStack->getCurrentRequest();

        $this->addSyliusProductCriterion($query, $queryBuilder, $request);
        $this->addBitBagSectionCriterion($query, $queryBuilder, $request);
        $this->addSyliusChannelFilterCriterion($query, $queryBuilder);

        $paginator = $this->mediaRepository->createFilterPaginator($queryBuilder);

        return $paginator->getNbResults();
    }

    public function isContextual(Query $query): bool
    {
        return $this->isSyliusProductContextual($query)
            || $this->isBitBagSectionContextual($query);
    }
}
