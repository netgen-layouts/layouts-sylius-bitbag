<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Layout\Resolver\TargetType;

use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface;
use Netgen\Layouts\Sylius\BitBag\Layout\Resolver\TargetType\Section;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class SectionTest extends TestCase
{
    /**
     * @var \PHPUnit\Framework\MockObject\MockObject&\BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface
     */
    private MockObject $repositoryMock;

    private Section $targetType;

    protected function setUp(): void
    {
        $this->repositoryMock = $this->createMock(SectionRepositoryInterface::class);

        $this->targetType = new Section();
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Layout\Resolver\TargetType\Section::getType
     */
    public function testGetType(): void
    {
        self::assertSame('bitbag_section', $this->targetType::getType());
    }
}
