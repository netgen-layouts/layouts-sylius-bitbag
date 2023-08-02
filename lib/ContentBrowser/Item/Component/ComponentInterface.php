<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Component;

use Netgen\Layouts\Sylius\BitBag\API\ComponentInterface as APIComponentInterface;

interface ComponentInterface
{
    /**
     * Returns the BitBag component.
     */
    public function getComponent(): APIComponentInterface;
}
