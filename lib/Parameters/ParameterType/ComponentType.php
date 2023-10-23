<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Parameters\ParameterType;

use Netgen\Layouts\Parameters\ParameterDefinition;
use Netgen\Layouts\Parameters\ParameterType;
use Netgen\Layouts\Sylius\BitBag\Validator\Constraint as BitBagConstraints;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints;

final class ComponentType extends ParameterType
{
    public static function getIdentifier(): string
    {
        return 'bitbag_component';
    }

    public function configureOptions(OptionsResolver $optionsResolver): void
    {
        $optionsResolver->setRequired(['component_type_identifier']);

        $optionsResolver->setAllowedTypes('component_type_identifier', ['string']);
    }

    protected function getValueConstraints(ParameterDefinition $parameterDefinition, $value): array
    {
        return [
            new Constraints\Type(['type' => 'string']),
            new BitBagConstraints\Component(),
        ];
    }
}
