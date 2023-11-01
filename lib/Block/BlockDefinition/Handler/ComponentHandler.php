<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Block\BlockDefinition\Handler;

use Netgen\Layouts\Block\BlockDefinition\BlockDefinitionHandler;
use Netgen\Layouts\Parameters\ParameterBuilderInterface;
use Netgen\Layouts\Parameters\ParameterType;
use Netgen\Layouts\Sylius\BitBag\Parameters\ParameterType\ComponentType;

final class ComponentHandler extends BlockDefinitionHandler
{
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
}
