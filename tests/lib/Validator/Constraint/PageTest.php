<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Validator\Constraint;

use Netgen\Layouts\Sylius\BitBag\Validator\Constraint\Page;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Page::class)]
final class PageTest extends TestCase
{
    public function testValidatedBy(): void
    {
        $constraint = new Page();
        self::assertSame('nglayouts_sylius_bitbag_page', $constraint->validatedBy());
    }
}
