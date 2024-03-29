<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler;

use Netgen\Layouts\API\Values\Collection\Query;
use Netgen\Layouts\Collection\QueryType\QueryTypeHandlerInterface;
use Netgen\Layouts\Parameters\ParameterBuilderInterface;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\BitBagEnabledTrait;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\BitBagSortingTrait;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\SyliusChannelFilterTrait;
use Netgen\Layouts\Sylius\BitBag\Repository\FrequentlyAskedQuestionRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

use const PHP_INT_MAX;

final class FrequentlyAskedQuestionHandler implements QueryTypeHandlerInterface
{
    use BitBagEnabledTrait;
    use BitBagSortingTrait;
    use SyliusChannelFilterTrait;

    /** @var array<string, string> */
    private array $sortingOptions = [
        'Position' => 'position',
        'Question' => 'translations.question',
        'Answer' => 'translations.answer',
        'Code' => 'code',
    ];

    public function __construct(
        private FrequentlyAskedQuestionRepositoryInterface $frequentlyAskedQuestionRepository,
        private LocaleContextInterface $localeContext,
    ) {}

    public function buildParameters(ParameterBuilderInterface $builder): void
    {
        $this->buildSyliusChannelFilterParameters($builder);
        $this->buildBitBagSortingParameters($builder, $this->sortingOptions);
    }

    public function getValues(Query $query, int $offset = 0, ?int $limit = null): iterable
    {
        $queryBuilder = $this->frequentlyAskedQuestionRepository->createListQueryBuilder(
            $this->localeContext->getLocaleCode(),
        );

        $this->addSyliusChannelFilterCriterion($query, $queryBuilder);
        $this->addBitBagEnabledCriterion($queryBuilder);
        $this->addBitBagSortingClause($query, $queryBuilder);

        $paginator = $this->frequentlyAskedQuestionRepository->createFilterPaginator($queryBuilder);

        $limit = $limit ?? PHP_INT_MAX;

        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage((int) ($offset / $limit) + 1);

        return $paginator->getCurrentPageResults();
    }

    public function getCount(Query $query): int
    {
        $queryBuilder = $this->frequentlyAskedQuestionRepository->createListQueryBuilder(
            $this->localeContext->getLocaleCode(),
        );

        $this->addSyliusChannelFilterCriterion($query, $queryBuilder);
        $this->addBitBagEnabledCriterion($queryBuilder);

        $paginator = $this->frequentlyAskedQuestionRepository->createFilterPaginator($queryBuilder);

        return $paginator->getNbResults();
    }

    public function isContextual(Query $query): bool
    {
        return false;
    }
}
