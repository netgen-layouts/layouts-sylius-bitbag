<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsSyliusBitBagBundle\EventListener\BitBag;

use Netgen\Layouts\Sylius\BitBag\API\ComponentInterface;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class ResourceShowListener implements EventSubscriberInterface
{
    public function __construct
    (
        private readonly RequestStack $requestStack,
    ) {}

    public static function getSubscribedEvents()
    {
        return ['sylius.resource.show' => 'onResourceShow'];
    }

    public function onResourceShow(ResourceControllerEvent $event): void
    {
        $subject = $event->getSubject();

        if (!$subject instanceof ComponentInterface) {
            return;
        }

        $currentRequest = $this->requestStack->getCurrentRequest();
        if ($currentRequest instanceof Request) {
            $currentRequest->attributes->set('nglayouts_sylius_bitbag_component_show_id', $subject->getId());
            $currentRequest->attributes->set('nglayouts_sylius_bitbag_component_show_identifier', $subject->getIdentifier());
        }
    }
}
