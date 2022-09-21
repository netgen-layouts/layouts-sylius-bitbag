<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs;

use BitBag\SyliusCmsPlugin\Entity\Block as BaseBlock;

final class Block extends BaseBlock
{
    public function __construct(
        int $id,
        string $code,
        string $name,
        bool $enabled = true
    ) {
        parent::__construct();

        $this->id = $id;
        $this->code = $code;
        $this->enabled = $enabled;

        $this->currentLocale = 'en';
        $this->setName($name);
    }
}
