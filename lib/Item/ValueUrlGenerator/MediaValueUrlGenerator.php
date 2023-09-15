<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Item\ValueUrlGenerator;

use Netgen\Layouts\Item\ValueUrlGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @implements \Netgen\Layouts\Item\ValueUrlGeneratorInterface<\BitBag\SyliusCmsPlugin\Entity\MediaInterface>
 */
final class MediaValueUrlGenerator implements ValueUrlGeneratorInterface
{
    public function __construct(private UrlGeneratorInterface $urlGenerator) {}

    public function generate(object $object): ?string
    {
        return $this->urlGenerator->generate(
            'bitbag_sylius_cms_plugin_admin_media_update',
            [
                'id' => $object->getId(),
            ],
        );
    }
}
