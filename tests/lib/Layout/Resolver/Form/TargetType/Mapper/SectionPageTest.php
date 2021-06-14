<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Layout\Resolver\Form\TargetType\Mapper;

use Netgen\ContentBrowser\Form\Type\ContentBrowserType;
use Netgen\Layouts\Sylius\BitBag\Layout\Resolver\Form\TargetType\Mapper\SectionPage;
use PHPUnit\Framework\TestCase;

final class SectionPageTest extends TestCase
{
    private SectionPage $mapper;

    protected function setUp(): void
    {
        $this->mapper = new SectionPage();
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Tests\Layout\Resolver\Form\TargetType\Mapper\SectionPage::getFormType
     */
    public function testGetFormType(): void
    {
        self::assertSame(ContentBrowserType::class, $this->mapper->getFormType());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Tests\Layout\Resolver\Form\TargetType\Mapper\SectionPage::getFormOptions
     */
    public function testGetFormOptions(): void
    {
        self::assertSame(
            [
                'item_type' => 'bitbag_section',
            ],
            $this->mapper->getFormOptions(),
        );
    }
}
