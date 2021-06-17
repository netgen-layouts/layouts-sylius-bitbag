<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Item\ValueUrlGenerator;

use Netgen\Layouts\Item\ValueUrlGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final class SectionValueUrlGenerator implements ValueUrlGeneratorInterface
{
    private UrlGeneratorInterface $urlGenerator;

    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    public function generate(object $object): ?string
    {
        return $this->urlGenerator->generate(
            'bitbag_sylius_cms_plugin_admin_section_update',
            [
                'id' => $object->getId(),
            ],
        );
    }
}