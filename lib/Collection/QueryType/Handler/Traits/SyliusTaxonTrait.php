<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits;

use Doctrine\ORM\QueryBuilder;
use Netgen\Layouts\Parameters\ParameterBuilderInterface;
use Netgen\Layouts\Parameters\ParameterCollectionInterface;
use Netgen\Layouts\Parameters\ParameterType;
use Netgen\Layouts\Sylius\Parameters\ParameterType as SyliusParameterType;
use Sylius\Component\Taxonomy\Model\TaxonInterface;
use Symfony\Component\HttpFoundation\RequestStack;

trait SyliusTaxonTrait
{
    private RequestStack $requestStack;

    /**
     * Builds the parameters for filtering by specific or contextual Sylius taxon.
     *
     * @param string[] $groups
     */
    private function buildSyliusTaxonParameters(ParameterBuilderInterface $builder, array $groups = []): void
    {
        $builder->add(
            'use_current_taxon',
            ParameterType\Compound\BooleanType::class,
            [
                'reverse' => true,
                'groups' => $groups,
            ],
        );

        $builder->get('use_current_taxon')->add(
            'sylius_taxon_id',
            SyliusParameterType\TaxonType::class,
            [
                'groups' => $groups,
            ],
        );
    }

    private function isSyliusTaxonContextual(ParameterCollectionInterface $parameterCollection): bool
    {
        return $parameterCollection->getParameter('use_current_taxon')->getValue() === true;
    }

    /**
     * Builds the criteria for filtering by Sylius taxon.
     */
    private function addSyliusTaxonCriterion(ParameterCollectionInterface $parameterCollection, QueryBuilder $queryBuilder): void
    {
        $useCurrentTaxon = $parameterCollection->getParameter('use_current_taxon')->getValue();
        $syliusTaxonId = $parameterCollection->getParameter('sylius_taxon_id')->getValue();

        if ($useCurrentTaxon !== true && $syliusTaxonId === null) {
            return;
        }

        if ($useCurrentTaxon) {
            $request = $this->requestStack->getCurrentRequest();
            $taxon = $request->attributes->get('nglayouts_sylius_taxon');

            $syliusTaxonId = $taxon instanceof TaxonInterface
                ? $taxon->getId()
                : $syliusTaxonId;
        }

        $queryBuilder->innerJoin('o.taxonomies', 'taxonomies');
        $queryBuilder->andWhere($queryBuilder->expr()->eq('taxonomies.id', ':taxonId'));
        $queryBuilder->setParameter(':taxonId', (int) $syliusTaxonId);
    }
}
