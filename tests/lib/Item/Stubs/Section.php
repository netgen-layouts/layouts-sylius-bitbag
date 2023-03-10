<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs;

use BitBag\SyliusCmsPlugin\Entity\Section as BaseSection;

final class Section extends BaseSection
{
    public function __construct(
        int $id,
        string $code,
        string $name,
    ) {
        parent::__construct();

        $this->id = $id;
        $this->code = $code;

        $this->currentLocale = 'en';
        $this->setName($name);
    }
}
