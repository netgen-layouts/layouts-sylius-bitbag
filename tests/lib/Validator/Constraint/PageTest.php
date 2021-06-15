<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Validator\Constraint;

use Netgen\Layouts\Sylius\BitBag\Validator\Constraint\Page;
use PHPUnit\Framework\TestCase;

final class PageTest extends TestCase
{
    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Validator\Constraint\Page::validatedBy
     */
    public function testValidatedBy(): void
    {
        $constraint = new Page();
        self::assertSame('nglayouts_sylius_bitbag_page', $constraint->validatedBy());
    }
}
