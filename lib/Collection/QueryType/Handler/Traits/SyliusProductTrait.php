<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits;

use Doctrine\ORM\QueryBuilder;
use Netgen\Layouts\Parameters\ParameterBuilderInterface;
use Netgen\Layouts\Parameters\ParameterCollectionInterface;
use Netgen\Layouts\Parameters\ParameterType;
use Netgen\Layouts\Sylius\Parameters\ParameterType as SyliusParameterType;
use Sylius\Component\Product\Model\ProductInterface;
use Symfony\Component\HttpFoundation\RequestStack;

trait SyliusProductTrait
{
    private RequestStack $requestStack;

    /**
     * Builds the parameters for filtering by specific or contextual Sylius product.
     *
     * @param string[] $groups
     */
    private function buildSyliusProductParameters(ParameterBuilderInterface $builder, array $groups = []): void
    {
        $builder->add(
            'use_current_product',
            ParameterType\Compound\BooleanType::class,
            [
                'reverse' => true,
                'groups' => $groups,
            ],
        );

        $builder->get('use_current_product')->add(
            'sylius_product_id',
            SyliusParameterType\ProductType::class,
            [
                'groups' => $groups,
            ],
        );
    }

    private function isSyliusProductContextual(ParameterCollectionInterface $parameterCollection): bool
    {
        return $parameterCollection->getParameter('use_current_product')->getValue() === true;
    }

    /**
     * Builds the criteria for filtering by Sylius product.
     */
    private function addSyliusProductCriterion(ParameterCollectionInterface $parameterCollection, QueryBuilder $queryBuilder): void
    {
        $useCurrentProduct = $parameterCollection->getParameter('use_current_product')->getValue();
        $syliusProductId = $parameterCollection->getParameter('sylius_product_id')->getValue();

        if ($useCurrentProduct !== true && $syliusProductId === null) {
            return;
        }

        if ($useCurrentProduct) {
            $request = $this->requestStack->getCurrentRequest();
            $product = $request->attributes->get('nglayouts_sylius_product');

            $syliusProductId = $product instanceof ProductInterface
                ? $product->getId()
                : $syliusProductId;
        }

        $queryBuilder->innerJoin('o.products', 'products');
        $queryBuilder->andWhere($queryBuilder->expr()->eq('products.id', ':productId'));
        $queryBuilder->setParameter(':productId', (int) $syliusProductId);
    }
}
