<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Stubs;

use BitBag\SyliusCmsPlugin\Entity\Section as BaseSection;

class Section extends BaseSection
{
    public function __construct(int $id, string $code)
    {
        parent::__construct();

        $this->id = $id;
        $this->code = $code;
    }
}
