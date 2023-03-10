<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Validator\Constraint;

use Netgen\Layouts\Sylius\BitBag\Validator\Constraint\Section;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Section::class)]
final class SectionTest extends TestCase
{
    public function testValidatedBy(): void
    {
        $constraint = new Section();
        self::assertSame('nglayouts_sylius_bitbag_section', $constraint->validatedBy());
    }
}
