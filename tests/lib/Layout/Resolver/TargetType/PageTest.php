<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Layout\Resolver\TargetType;

use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use Netgen\Layouts\Sylius\BitBag\Layout\Resolver\TargetType\Page;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class PageTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject&\BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface
     */
    private MockObject $repositoryMock;

    private Page $targetType;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(PageRepositoryInterface::class);

        $this->targetType = new Page();
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Layout\Resolver\TargetType\Page::getType
     */
    public function testGetType(): void
    {
        self::assertSame('bitbag_page', $this->targetType::getType());
    }
}
