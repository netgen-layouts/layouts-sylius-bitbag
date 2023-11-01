<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Block\BlockDefinition\Handler;

use Netgen\Layouts\API\Values\Block\Block;
use Netgen\Layouts\Block\BlockDefinition\BlockDefinitionHandler;
use Netgen\Layouts\Block\DynamicParameters;
use Netgen\Layouts\Parameters\ParameterBuilderInterface;
use Netgen\Layouts\Parameters\ParameterType;
use Netgen\Layouts\Sylius\BitBag\API\ComponentInterface;
use Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Component\ItemValue;
use Netgen\Layouts\Sylius\BitBag\Parameters\ParameterType\ComponentType;
use Netgen\Layouts\Sylius\BitBag\Repository\ComponentRepositoryInterface;

final class ComponentHandler extends BlockDefinitionHandler
{
    public function __construct
    (
        private readonly ComponentRepositoryInterface $componentRepository,
    ) {}

    public function buildParameters(ParameterBuilderInterface $builder): void
    {
        $builder->add(
            'component_type_identifier',
            ParameterType\HiddenType::class,
            [
                'required' => true,
                'readonly' => true,
            ],
        );

        $builder->add(
            'content',
            ComponentType::class,
            [
                'component_type_identifier' => 'bitbag_component',
                'label' => 'block.bitbag_component.content',
            ],
        );
    }

    public function getDynamicParameters(DynamicParameters $params, Block $block): void
    {
        $params['resource'] = null;

        if ($block->getParameter('content')->isEmpty()) {
            return;
        }

        $itemValue = ItemValue::fromValue($block->getParameter('content')->getValue());

        $componentItem = $this->componentRepository->load($itemValue->getComponentTypeIdentifier(), $itemValue->getId());

        if ($componentItem instanceof ComponentInterface) {
            $params['resource'] = $componentItem;
        }
    }
}
