<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Component;

use Netgen\Layouts\Sylius\BitBag\API\ComponentTranslationInterface;
use Sylius\Component\Resource\Model\AbstractTranslation;

abstract class AbstractComponentTranslation extends AbstractTranslation implements ComponentTranslationInterface
{
    protected int $id;

    protected string $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}
