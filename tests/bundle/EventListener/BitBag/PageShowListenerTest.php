<?php

declare(strict_types=1);

namespace Netgen\Bundle\LayoutsSyliusBitBagBundle\Tests\EventListener\BitBag;

use Netgen\Bundle\LayoutsSyliusBitBagBundle\EventListener\BitBag\PageShowListener;
use Netgen\Layouts\Context\Context;
use Netgen\Layouts\Sylius\BitBag\Tests\Stubs\Page;
use Netgen\Layouts\Sylius\BitBag\Tests\Stubs\Section;
use PHPUnit\Framework\TestCase;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

final class PageShowListenerTest extends TestCase
{
    private PageShowListener $listener;

    private RequestStack $requestStack;

    private Context $context;

    protected function setUp(): void
    {
        $this->requestStack = new RequestStack();
        $this->context = new Context();

        $this->listener = new PageShowListener($this->requestStack, $this->context);
    }

    /**
     * @covers \Netgen\Bundle\LayoutsSyliusBitBagBundle\EventListener\BitBag\PageShowListener::__construct
     * @covers \Netgen\Bundle\LayoutsSyliusBitBagBundle\EventListener\BitBag\PageShowListener::getSubscribedEvents
     */
    public function testGetSubscribedEvents(): void
    {
        self::assertSame(
            ['bitbag_sylius_cms_plugin.page.show' => 'onPageShow'],
            $this->listener::getSubscribedEvents(),
        );
    }

    /**
     * @covers \Netgen\Bundle\LayoutsSyliusBitBagBundle\EventListener\BitBag\PageShowListener::onPageShow
     */
    public function testOnPageShow(): void
    {
        $request = Request::create('/');
        $this->requestStack->push($request);

        $page = new Page(42, 'contact');
        $event = new ResourceControllerEvent($page);
        $this->listener->onPageShow($event);

        self::assertSame($page, $request->attributes->get('nglayouts_sylius_bitbag_page'));

        self::assertTrue($this->context->has('bitbag_page_id'));
        self::assertSame(42, $this->context->get('bitbag_page_id'));
    }

    /**
     * @covers \Netgen\Bundle\LayoutsSyliusBitBagBundle\EventListener\BitBag\PageShowListener::onPageShow
     */
    public function testOnPageShowWithoutPage(): void
    {
        $request = Request::create('/');
        $this->requestStack->push($request);

        $section = new Section(5, 'blog');
        $event = new ResourceControllerEvent($section);
        $this->listener->onPageShow($event);

        self::assertFalse($request->attributes->has('nglayouts_sylius_bitbag_page'));
        self::assertFalse($this->context->has('bitbag_page_id'));
    }
}
