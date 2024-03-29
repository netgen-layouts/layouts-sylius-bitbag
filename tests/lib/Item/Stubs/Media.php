<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Item\Stubs;

use BitBag\SyliusCmsPlugin\Entity\Media as BaseMedia;

final class Media extends BaseMedia
{
    public function __construct(
        int $id,
        ?string $code = null,
        ?string $name = null,
        string $type = 'file',
        string $mimeType = '',
        bool $enabled = true,
    ) {
        parent::__construct();

        $this->id = $id;
        $this->code = $code;
        $this->enabled = $enabled;

        $this->currentLocale = 'en';
        $this->setName($name);
        $this->setType($type);
        $this->setMimeType($mimeType);
    }
}
