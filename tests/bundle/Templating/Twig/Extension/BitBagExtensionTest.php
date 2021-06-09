<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsSyliusBitBagBundle\Tests\Templating\Twig\Extension;

use Netgen\Bundle\LayoutsSyliusBitBagBundle\Templating\Twig\Extension\BitBagExtension;
use PHPUnit\Framework\TestCase;
use Twig\TwigFunction;

final class BitBagExtensionTest extends TestCase
{
    private BitBagExtension $extension;

    protected function setUp(): void
    {
        $this->extension = new BitBagExtension();
    }

    /**
     * @covers \Netgen\Bundle\LayoutsSyliusBitBagBundle\Templating\Twig\Extension\BitBagExtension::getFunctions
     */
    public function testGetFunctions(): void
    {
        self::assertNotEmpty($this->extension->getFunctions());
        self::assertContainsOnlyInstancesOf(TwigFunction::class, $this->extension->getFunctions());
    }
}
