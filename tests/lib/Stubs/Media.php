<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Stubs;

use BitBag\SyliusCmsPlugin\Entity\Media as BaseMedia;

final class Media extends BaseMedia
{
    public function __construct(int $id, ?string $code = null)
    {
        parent::__construct();

        $this->id = $id;
        $this->code = $code;
    }
}
