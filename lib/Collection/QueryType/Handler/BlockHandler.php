<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use Netgen\Layouts\API\Values\Collection\Query;
use Netgen\Layouts\Collection\QueryType\QueryTypeHandlerInterface;
use Netgen\Layouts\Parameters\ParameterBuilderInterface;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\BitBagEnabledTrait;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\BitBagSectionTrait;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\BitBagSortingTrait;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\SyliusChannelFilterTrait;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\SyliusProductTrait;
use Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits\SyliusTaxonTrait;
use Netgen\Layouts\Sylius\BitBag\Repository\BlockRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\HttpFoundation\RequestStack;

use function max;

use const PHP_INT_MAX;

final class BlockHandler implements QueryTypeHandlerInterface
{
    use BitBagEnabledTrait;
    use BitBagSectionTrait;
    use BitBagSortingTrait;
    use SyliusChannelFilterTrait;
    use SyliusProductTrait;
    use SyliusTaxonTrait;

    /** @var array<string, string> */
    private array $sortingOptions = [
        'Name' => 'translation.name',
        'Code' => 'code',
    ];

    public function __construct(
        private BlockRepositoryInterface $blockRepository,
        private LocaleContextInterface $localeContext,
        private RequestStack $requestStack,
    ) {}

    public function buildParameters(ParameterBuilderInterface $builder): void
    {
        $this->buildSyliusProductParameters($builder);
        $this->buildSyliusTaxonParameters($builder);
        $this->buildBitBagSectionParameters($builder);
        $this->buildSyliusChannelFilterParameters($builder);
        $this->buildBitBagSortingParameters($builder, $this->sortingOptions);
    }

    /**
     * @return BlockInterface[]
     */
    public function getValues(Query $query, int $offset = 0, ?int $limit = null): array
    {
        $queryBuilder = $this->blockRepository->createListQueryBuilder(
            $this->localeContext->getLocaleCode(),
        );

        $request = $this->requestStack->getCurrentRequest();

        $this->addSyliusProductCriterion($query, $queryBuilder, $request);
        $this->addSyliusTaxonCriterion($query, $queryBuilder, $request);
        $this->addBitBagSectionCriterion($query, $queryBuilder, $request);
        $this->addSyliusChannelFilterCriterion($query, $queryBuilder);
        $this->addBitBagEnabledCriterion($queryBuilder);
        $this->addBitBagSortingClause($query, $queryBuilder);

        $limit = $limit === null ? PHP_INT_MAX : max(0, $limit);
        $offset = max(0, $offset);

        return $queryBuilder->setFirstResult($offset)
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function getCount(Query $query): int
    {
        $queryBuilder = $this->blockRepository->createListQueryBuilder(
            $this->localeContext->getLocaleCode(),
        );

        $request = $this->requestStack->getCurrentRequest();

        $this->addSyliusProductCriterion($query, $queryBuilder, $request);
        $this->addSyliusTaxonCriterion($query, $queryBuilder, $request);
        $this->addBitBagSectionCriterion($query, $queryBuilder, $request);
        $this->addSyliusChannelFilterCriterion($query, $queryBuilder);
        $this->addBitBagEnabledCriterion($queryBuilder);

        return (int)$queryBuilder
            ->select('count(o.id)')
            ->getQuery()
            ->getSingleScalarResult();
    }

    public function isContextual(Query $query): bool
    {
        return $this->isSyliusProductContextual($query)
            || $this->isSyliusTaxonContextual($query)
            || $this->isBitBagSectionContextual($query);
    }
}
