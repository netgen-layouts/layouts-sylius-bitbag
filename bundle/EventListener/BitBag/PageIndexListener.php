<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsSyliusBitBagBundle\EventListener\BitBag;

use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface;
use Netgen\Layouts\Context\Context;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class PageIndexListener implements EventSubscriberInterface
{
    public function __construct(
        private SectionRepositoryInterface $sectionRepository,
        private LocaleContextInterface $localeContext,
        private RequestStack $requestStack,
        private Context $context,
    ) {}

    public static function getSubscribedEvents(): array
    {
        return ['bitbag_sylius_cms_plugin.page.index' => 'onPageIndex'];
    }

    /**
     * Sets the currently displayed section to the request,
     * to be able to match with layout resolver.
     */
    public function onPageIndex(ResourceControllerEvent $event): void
    {
        $currentRequest = $this->requestStack->getCurrentRequest();
        if (!$currentRequest instanceof Request) {
            return;
        }

        // Only sane way to extract the reference to the section
        if (!$currentRequest->attributes->has('sectionCode')) {
            return;
        }

        $section = $this->sectionRepository->findOneByCode(
            $currentRequest->attributes->get('sectionCode'),
            $this->localeContext->getLocaleCode(),
        );

        if (!$section instanceof SectionInterface) {
            return;
        }

        $currentRequest->attributes->set('nglayouts_sylius_bitbag_section', $section);
        // We set context here instead in a ContextProvider, since bitbag_sylius_cms_plugin.page.index
        // event happens too late, after onKernelRequest event has already been executed
        $this->context->set('bitbag_section_id', (int) $section->getId());
    }
}
