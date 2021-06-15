<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Validator\Constraint;

use Netgen\Layouts\Sylius\BitBag\Validator\Constraint\Section;
use PHPUnit\Framework\TestCase;

final class SectionTest extends TestCase
{
    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Validator\Constraint\Section::validatedBy
     */
    public function testValidatedBy(): void
    {
        $constraint = new Section();
        self::assertSame('nglayouts_sylius_bitbag_section', $constraint->validatedBy());
    }
}
