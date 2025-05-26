<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Item\ValueUrlGenerator;

use Netgen\Layouts\Item\ExtendedValueUrlGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @implements \Netgen\Layouts\Item\ExtendedValueUrlGeneratorInterface<\BitBag\SyliusCmsPlugin\Entity\PageInterface>
 */
final class PageValueUrlGenerator implements ExtendedValueUrlGeneratorInterface
{
    public function __construct(private UrlGeneratorInterface $urlGenerator) {}

    public function generateDefaultUrl(object $object): ?string
    {
        return $this->urlGenerator->generate(
            'bitbag_sylius_cms_plugin_shop_page_show',
            [
                'slug' => $object->getSlug(),
            ],
        );
    }

    public function generateAdminUrl(object $object): ?string
    {
        return $this->urlGenerator->generate(
            'bitbag_sylius_cms_plugin_admin_page_update',
            [
                'id' => $object->getId(),
            ],
        );
    }

    public function generate(object $object): ?string
    {
        return $this->generateDefaultUrl($object);
    }
}
