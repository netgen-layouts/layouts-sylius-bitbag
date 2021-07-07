<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler;

use Netgen\Layouts\API\Values\Collection\Query;
use Netgen\Layouts\Collection\QueryType\QueryTypeHandlerInterface;
use Netgen\Layouts\Parameters\ParameterBuilderInterface;
use Netgen\Layouts\Parameters\ParameterType;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\SyliusChannelFilterTrait;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\SyliusProductTrait;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\SyliusTaxonTrait;
use Netgen\Layouts\Sylius\BitBag\Repository\BlockRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class BlockHandler implements QueryTypeHandlerInterface
{
    use SyliusProductTrait;
    use SyliusTaxonTrait;
    use SyliusChannelFilterTrait;

    private BlockRepositoryInterface $blockRepository;

    private LocaleContextInterface $localeContext;

    public function __construct(
        BlockRepositoryInterface $blockRepository,
        LocaleContextInterface $localeContext
    ) {
        $this->blockRepository = $blockRepository;
        $this->localeContext = $localeContext;
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

        $this->addSyliusProductCriterion($query, $queryBuilder);
        $this->addSyliusTaxonCriterion($query, $queryBuilder);
        $this->addSyliusChannelFilterCriterion($query, $queryBuilder);

        $paginator = $this->blockRepository->createFilterPaginator($queryBuilder);
        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage((int) ($offset / $limit) + 1);

        return $paginator->getCurrentPageResults();
    }

    public function getCount(Query $query): int
    {
        $queryBuilder = $this->blockRepository->createListQueryBuilder(
            $this->localeContext->getLocaleCode(),
        );

        $this->addSyliusProductCriterion($query, $queryBuilder);
        $this->addSyliusTaxonCriterion($query, $queryBuilder);
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
