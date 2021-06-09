<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Layout\Resolver\Form\TargetType\Mapper;

use Netgen\ContentBrowser\Form\Type\ContentBrowserType;
use Netgen\Layouts\Sylius\BitBag\Layout\Resolver\Form\TargetType\Mapper\Page;
use PHPUnit\Framework\TestCase;

final class PageTest extends TestCase
{
    private Page $mapper;

    protected function setUp(): void
    {
        $this->mapper = new Page();
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Tests\Layout\Resolver\Form\TargetType\Mapper\Page::getFormType
     */
    public function testGetFormType(): void
    {
        self::assertSame(ContentBrowserType::class, $this->mapper->getFormType());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Tests\Layout\Resolver\Form\TargetType\Mapper\Page::getFormOptions
     */
    public function testGetFormOptions(): void
    {
        self::assertSame(
            [
                'item_type' => 'bitbag_page',
            ],
            $this->mapper->getFormOptions(),
        );
    }
}
