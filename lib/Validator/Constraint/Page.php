<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Validator\Constraint;

use Symfony\Component\Validator\Constraint;

class Page extends Constraint
{
    public string $message = 'netgen_layouts.sylius.bitbag.page.page_not_found';

    public function validatedBy(): string
    {
        return 'nglayouts_sylius_bitbag_page';
    }
}
