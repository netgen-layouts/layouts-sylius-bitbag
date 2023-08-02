<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Component;

use Netgen\Layouts\Sylius\BitBag\Component\AbstractComponent;
use Netgen\Layouts\Sylius\BitBag\Component\AbstractComponentTranslation;
use Netgen\Layouts\Sylius\BitBag\Tests\Stubs\Component as ComponentStub;
use Netgen\Layouts\Sylius\BitBag\Tests\Stubs\ComponentTranslation as ComponentTranslationStub;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(AbstractComponent::class)]
final class AbstractComponentTest extends TestCase
{
    public function test(): void
    {
        $stub = new ComponentStub(2, 'Test component');
        $translationStub = new ComponentTranslationStub(2, 'Test component');

        self::assertSame(2, $stub->getId());
        self::assertSame('Test component', $stub->getName());
        self::assertInstanceOf(AbstractComponentTranslation::class, $stub->getTranslation());
        self::assertSame($translationStub->getId(), $stub->getTranslation()->getId());
        self::assertSame($translationStub->getName(), $stub->getTranslation()->getName());
    }
}
