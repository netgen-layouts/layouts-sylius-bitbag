<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Layout\Resolver\Form\TargetType\Mapper;

use Netgen\ContentBrowser\Form\Type\ContentBrowserType;
use Netgen\Layouts\Sylius\BitBag\Layout\Resolver\Form\TargetType\Mapper\Section;
use PHPUnit\Framework\TestCase;

final class SectionTest extends TestCase
{
    private Section $mapper;

    protected function setUp(): void
    {
        $this->mapper = new Section();
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Tests\Layout\Resolver\Form\TargetType\Mapper\Section::getFormType
     */
    public function testGetFormType(): void
    {
        self::assertSame(ContentBrowserType::class, $this->mapper->getFormType());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Tests\Layout\Resolver\Form\TargetType\Mapper\Section::getFormOptions
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
