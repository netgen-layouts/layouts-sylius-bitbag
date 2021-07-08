<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Parameters\Form\Mapper;

use Netgen\ContentBrowser\Form\Type\ContentBrowserType;
use Netgen\Layouts\Parameters\ParameterDefinition;
use Netgen\Layouts\Sylius\BitBag\Parameters\Form\Mapper\SectionMapper;
use Netgen\Layouts\Sylius\BitBag\Parameters\ParameterType\SectionType as ParameterType;
use PHPUnit\Framework\TestCase;

final class SectionMapperTest extends TestCase
{
    private SectionMapper $mapper;

    protected function setUp(): void
    {
        $this->mapper = new SectionMapper();
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Parameters\Form\Mapper\SectionMapper::getFormType
     */
    public function testGetFormType(): void
    {
        self::assertSame(ContentBrowserType::class, $this->mapper->getFormType());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Parameters\Form\Mapper\SectionMapper::mapOptions
     */
    public function testMapOptions(): void
    {
        self::assertSame(
            [
                'item_type' => 'bitbag_section',
                'required' => false,
            ],
            $this->mapper->mapOptions(ParameterDefinition::fromArray(['type' => new ParameterType(), 'isRequired' => false])),
        );
    }
}
