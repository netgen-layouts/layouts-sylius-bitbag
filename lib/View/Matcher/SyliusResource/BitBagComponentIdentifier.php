<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\View\Matcher\SyliusResource;

use Netgen\Layouts\Sylius\BitBag\API\ComponentInterface;
use Netgen\Layouts\Sylius\View\View\SyliusResourceViewInterface;
use Netgen\Layouts\View\Matcher\MatcherInterface;
use Netgen\Layouts\View\ViewInterface;

class BitBagComponentIdentifier implements MatcherInterface
{
    public function match(ViewInterface $view, array $config): bool
    {
        if (!$view instanceof SyliusResourceViewInterface) {
            return false;
        }

        if (!$view->getResource() instanceof ComponentInterface) {
            return false;
        }

        return in_array($view->getResource()->getIdentifier(), $config);
    }
}
