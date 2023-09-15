<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Item\ValueUrlGenerator;

use Netgen\Layouts\Item\ValueUrlGeneratorInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

/**
 * @implements \Netgen\Layouts\Item\ValueUrlGeneratorInterface<\BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestionInterface>
 */
final class FrequentlyAskedQuestionValueUrlGenerator implements ValueUrlGeneratorInterface
{
    public function __construct(private UrlGeneratorInterface $urlGenerator) {}

    public function generate(object $object): ?string
    {
        return $this->urlGenerator->generate(
            'bitbag_sylius_cms_plugin_admin_frequently_asked_question_update',
            [
                'id' => $object->getId(),
            ],
        );
    }
}
