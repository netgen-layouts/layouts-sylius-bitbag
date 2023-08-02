<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Component;

use Netgen\Layouts\Sylius\BitBag\API\ComponentInterface;
use Netgen\Layouts\Sylius\BitBag\API\ComponentTranslationInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;
use Sylius\Component\Resource\Model\ToggleableTrait;
use Sylius\Component\Resource\Model\TranslatableTrait;
use Sylius\Component\Resource\Model\TranslationInterface;

abstract class AbstractComponent implements ComponentInterface
{
    use TimestampableTrait;
    use ToggleableTrait;
    use TranslatableTrait {
        __construct as protected initializeTranslationsCollection;
    }

    protected int $id;

    public function __construct()
    {
        $this->initializeTranslationsCollection();

        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        /** @var \Netgen\Layouts\Sylius\BitBag\API\ComponentTranslationInterface $componentTranslation */
        $componentTranslation = $this->getComponentTranslation();

        return $componentTranslation->getName();
    }

    protected function getComponentTranslation(): ComponentTranslationInterface|TranslationInterface
    {
        return $this->getTranslation();
    }
}
