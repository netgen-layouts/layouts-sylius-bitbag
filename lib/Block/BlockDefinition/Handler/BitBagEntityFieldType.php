<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Block\BlockDefinition\Handler;

enum BitBagEntityFieldType: string
{
    case STRING = 'string';

    case NUMBER = 'number';

    case MEDIA = 'media';

    case DATETIME = 'datetime';

    case BOOLEAN = 'boolean';

    case OTHER = 'other';

    case CONTENT = 'content';
}
