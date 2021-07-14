<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler\Traits;

use Netgen\Layouts\Parameters\ParameterBuilderInterface;
use Netgen\Layouts\Parameters\ParameterType;

trait SyliusChannelFilterTrait
{
    /**
     * Builds the parameters for filtering by Sylius channel.
     *
     * @param string[] $groups
     */
    private function buildSyliusChannelFilterParameters(ParameterBuilderInterface $builder, array $groups = []): void
    {
        $builder->add(
            'filter_by_channel',
            ParameterType\Compound\BooleanType::class,
            [
                'groups' => $groups,
            ],
        );

        $builder->get('filter_by_channel')->add(
            'channels_filter',
            ParameterType\ChoiceType::class,
            [
                'required' => true,
                'options' => [
                    'Include channels' => 'include',
                    'Exclude channels' => 'exclude',
                ],
                'groups' => $groups,
            ],
        );
    }
}
