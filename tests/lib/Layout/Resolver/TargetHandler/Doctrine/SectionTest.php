<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Layout\Resolver\TargetHandler\Doctrine;

use Netgen\Layouts\Sylius\BitBag\Layout\Resolver\TargetHandler\Doctrine\Page;
use Netgen\Layouts\Tests\Layout\Resolver\TargetHandler\Doctrine\AbstractTargetHandlerTest;
use Netgen\Layouts\Persistence\Values\LayoutResolver\RuleGroup;
use Netgen\Layouts\Persistence\Values\Value;
use Netgen\Layouts\Persistence\Doctrine\QueryHandler\TargetHandlerInterface;

final class SectionTest extends AbstractTargetHandlerTest
{
    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Layout\Resolver\TargetHandler\Doctrine\Page::handleQuery
     */
    public function testMatchRules(): void
    {
        $rules = $this->handler->matchRules(
            $this->handler->loadRuleGroup(RuleGroup::ROOT_UUID, Value::STATUS_PUBLISHED),
            $this->getTargetIdentifier(),
            2,
        );

        self::assertCount(2, $rules);
        self::assertSame(4, $rules[0]->id);
    }

    protected function getTargetIdentifier(): string
    {
        return 'bitbag_section';
    }

    protected function getTargetHandler(): TargetHandlerInterface
    {
        return new Page();
    }

    protected function insertDatabaseFixtures(string $fixturesPath): void
    {
        parent::insertDatabaseFixtures(__DIR__ . '/../../../../../_fixtures/data.php');
    }
}
