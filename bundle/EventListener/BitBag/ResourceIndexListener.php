<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsSyliusBitBagBundle\EventListener\BitBag;

use Netgen\Layouts\Sylius\BitBag\API\ComponentInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Bundle\ResourceBundle\Grid\View\ResourceGridView;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ResourceIndexListener implements EventSubscriberInterface
{
    public function __construct
    (
        private readonly RequestStack $requestStack,
    ) {}

    public static function getSubscribedEvents()
    {
        return ['sylius.resource.index' => 'onResourceIndex'];
    }

    public function onResourceIndex(ResourceControllerEvent $event): void
    {
        $subject = $event->getSubject();

        if (!$subject instanceof ResourceGridView) {
            return;
        }

        $firstObject = $subject->getData()?->getCurrentPageResults()[0] ?? null;

        if (!$firstObject instanceof ComponentInterface) {
            return;
        }

        $componentIdentifier = $firstObject?->getIdentifier() ?? null;
        $componentId = $subject?->getRequestConfiguration()?->getRequest()?->query?->get('id') ?? null;

        if ($componentIdentifier === null || $componentId === null) {
            return;
        }

        $currentRequest = $this->requestStack->getCurrentRequest();
        if ($currentRequest instanceof Request) {
            $currentRequest->attributes->set('nglayouts_sylius_bitbag_component_index_selected_id', $componentId);
            $currentRequest->attributes->set('nglayouts_sylius_bitbag_component_index_identifier', $componentIdentifier);
        }
    }
}
