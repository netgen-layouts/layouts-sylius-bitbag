<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Layout\Resolver\TargetHandler\Doctrine;

use Netgen\Layouts\Persistence\Doctrine\QueryHandler\TargetHandlerInterface;
use Netgen\Layouts\Persistence\Values\LayoutResolver\RuleGroup;
use Netgen\Layouts\Persistence\Values\Value;
use Netgen\Layouts\Sylius\BitBag\Layout\Resolver\TargetHandler\Doctrine\SectionPage;
use Netgen\Layouts\Tests\Layout\Resolver\TargetHandler\Doctrine\AbstractTargetHandlerTest;

final class SectionPageTest extends AbstractTargetHandlerTest
{
    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Layout\Resolver\TargetHandler\Doctrine\SectionPage::handleQuery
     */
    public function testMatchRules(): void
    {
        $rules = $this->handler->matchRules(
            $this->handler->loadRuleGroup(RuleGroup::ROOT_UUID, Value::STATUS_PUBLISHED),
            $this->getTargetIdentifier(),
            [1, 2, 43, 13],
        );

        self::assertCount(2, $rules);
        self::assertSame(6, $rules[0]->id);
    }

    protected function getTargetIdentifier(): string
    {
        return 'bitbag_section_page';
    }

    protected function getTargetHandler(): TargetHandlerInterface
    {
        return new SectionPage();
    }

    protected function insertDatabaseFixtures(string $fixturesPath): void
    {
        parent::insertDatabaseFixtures(__DIR__ . '/../../../../../_fixtures/data.php');
    }
}
