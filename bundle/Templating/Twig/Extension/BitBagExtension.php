<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsSyliusBitBagBundle\Templating\Twig\Extension;

use Netgen\Bundle\LayoutsSyliusBitBagBundle\Templating\Twig\Runtime\BitBagRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class BitBagExtension extends AbstractExtension
{
    /**
     * @return \Twig\TwigFunction[]
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'nglayouts_sylius_bitbag_page_name',
                [BitBagRuntime::class, 'getPageName'],
            ),
            new TwigFunction(
                'nglayouts_sylius_bitbag_section_name',
                [BitBagRuntime::class, 'getSectionName'],
            ),
            new TwigFunction(
                'nglayouts_sylius_bitbag_component_create_route',
                [BitBagRuntime::class, 'getComponentCreateRoute'],
            ),
            new TwigFunction(
                'nglayouts_sylius_bitbag_component_update_route',
                [BitBagRuntime::class, 'getComponentUpdateRoute'],
            ),
        ];
    }
}
