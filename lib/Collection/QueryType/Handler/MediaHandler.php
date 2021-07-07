<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler;

use Netgen\Layouts\API\Values\Collection\Query;
use Netgen\Layouts\Collection\QueryType\QueryTypeHandlerInterface;
use Netgen\Layouts\Parameters\ParameterBuilderInterface;
use Netgen\Layouts\Parameters\ParameterType;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\SyliusChannelFilterTrait;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\SyliusProductTrait;
use Netgen\Layouts\Sylius\BitBag\Repository\MediaRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class MediaHandler implements QueryTypeHandlerInterface
{
    use SyliusProductTrait;

    private MediaRepositoryInterface $mediaRepository;

    private LocaleContextInterface $localeContext;

    public function __construct(
        MediaRepositoryInterface $mediaRepository,
        LocaleContextInterface $localeContext
    ) {
        $this->mediaRepository = $mediaRepository;
        $this->localeContext = $localeContext;
    }

    public function buildParameters(ParameterBuilderInterface $builder): void
    {
        $this->buildSyliusProductParameters($builder, $advancedGroup);
    }

    public function getValues(Query $query, int $offset = 0, ?int $limit = null): iterable
    {
        $queryBuilder = $this->mediaRepository->createListQueryBuilder(
            $this->localeContext->getLocaleCode(),
        );

        $this->addSyliusProductCriterion($query, $queryBuilder);

        $paginator = $this->mediaRepository->createFilterPaginator($queryBuilder);
        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage((int) ($offset / $limit) + 1);

        return $paginator->getCurrentPageResults();
    }

    public function getCount(Query $query): int
    {
        $queryBuilder = $this->mediaRepository->createListQueryBuilder(
            $this->localeContext->getLocaleCode(),
        );

        $this->addSyliusProductCriterion($query, $queryBuilder);

        $paginator = $this->mediaRepository->createFilterPaginator($queryBuilder);

        return $paginator->getNbResults();
    }

    public function isContextual(Query $query): bool
    {
        return $this->isSyliusProductContextual($query);
    }
}
