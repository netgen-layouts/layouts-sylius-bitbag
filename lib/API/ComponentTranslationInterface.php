<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\API;

use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TranslationInterface;

interface ComponentTranslationInterface extends ResourceInterface, TranslationInterface
{
    public function getName(): string;

    public function setName(string $name): void;
}