<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Stubs;

use Netgen\Layouts\Sylius\BitBag\Component\AbstractComponent;
use Sylius\Component\Resource\Model\TranslationInterface;

final class Component extends AbstractComponent
{
    private string $name;

    public function __construct(int $id, string $name)
    {
        parent::__construct();

        $this->id = $id;
        $this->name = $name;
    }

    public static function getIdentifier(): string
    {
        return 'component_stub';
    }

    protected function createTranslation(): TranslationInterface
    {
        return new ComponentTranslation($this->id, $this->name);
    }
}
