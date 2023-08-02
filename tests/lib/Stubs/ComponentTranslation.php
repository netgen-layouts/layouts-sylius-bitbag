<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Stubs;

use Netgen\Layouts\Sylius\BitBag\Component\AbstractComponentTranslation;

final class ComponentTranslation extends AbstractComponentTranslation
{
    public function __construct(int $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }
}
