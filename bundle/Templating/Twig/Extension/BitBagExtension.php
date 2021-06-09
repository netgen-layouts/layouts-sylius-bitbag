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
        ];
    }
}
