<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\ContentBrowser\Backend;

use ArrayIterator;
use Netgen\ContentBrowser\Backend\SearchQuery;
use Netgen\ContentBrowser\Exceptions\NotFoundException;
use Netgen\Layouts\Browser\Item\Layout\RootLocation;
use Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend;
use Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Section\Item;
use Netgen\Layouts\Sylius\BitBag\Repository\SectionRepositoryInterface;
use Netgen\Layouts\Sylius\BitBag\Tests\Stubs\Section;
use Pagerfanta\Adapter\AdapterInterface;
use Pagerfanta\Pagerfanta;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Locale\Context\LocaleContextInterface;

final class SectionBackendTest extends TestCase
{
    private MockObject $sectionRepositoryMock;

    private SectionBackend $backend;

    protected function setUp(): void
    {
        $this->sectionRepositoryMock = $this->createMock(SectionRepositoryInterface::class);
        $localeContextMock = $this->createMock(LocaleContextInterface::class);

        $localeContextMock
            ->expects(self::any())
            ->method('getLocaleCode')
            ->willReturn('en');

        $this->backend = new SectionBackend(
            $this->sectionRepositoryMock,
            $localeContextMock,
        );
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::__construct
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::buildLocations
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::getSections
     */
    public function testGetSections(): void
    {
        $locations = $this->backend->getSections();

        self::assertCount(1, $locations);
        self::assertContainsOnlyInstancesOf(RootLocation::class, $locations);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::buildLocation
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::loadLocation
     */
    public function testLoadLocation(): void
    {
        $location = $this->backend->loadLocation(1);

        self::assertInstanceOf(RootLocation::class, $location);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::buildItem
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::loadItem
     */
    public function testLoadItem(): void
    {
        $this->sectionRepositoryMock
            ->expects(self::once())
            ->method('find')
            ->with(self::identicalTo(1))
            ->willReturn(new Section(1, 'blog'));

        $item = $this->backend->loadItem(1);

        self::assertSame(1, $item->getValue());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::loadItem
     */
    public function testLoadItemThrowsNotFoundException(): void
    {
        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Item with value "1" not found.');

        $this->sectionRepositoryMock
            ->expects(self::once())
            ->method('find')
            ->with(self::identicalTo(1))
            ->willReturn(null);

        $this->backend->loadItem(1);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::getSubLocations
     */
    public function testGetSubLocations(): void
    {
        $locations = $this->backend->getSubLocations(new RootLocation());

        self::assertCount(0, $locations);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::getSubLocationsCount
     */
    public function testGetSubLocationsCount(): void
    {
        $count = $this->backend->getSubLocationsCount(new RootLocation());

        self::assertSame(0, $count);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::buildItem
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::buildItems
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::getSubItems
     */
    public function testGetSubItems(): void
    {
        $pagerfantaAdapterMock = $this->createMock(AdapterInterface::class);
        $pagerfantaAdapterMock
            ->expects(self::any())
            ->method('getSlice')
            ->with(self::identicalTo(0), self::identicalTo(25))
            ->willReturn(new ArrayIterator([new Section(42, 'blog'), new Section(43, 'news')]));

        $this->sectionRepositoryMock
            ->expects(self::once())
            ->method('createListPaginator')
            ->with(self::identicalTo('en'))
            ->willReturn(new Pagerfanta($pagerfantaAdapterMock));

        $items = $this->backend->getSubItems(
            new RootLocation(),
        );

        self::assertCount(2, $items);
        self::assertContainsOnlyInstancesOf(Item::class, $items);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::buildItem
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::buildItems
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::getSubItems
     */
    public function testGetSubItemsWithOffsetAndLimit(): void
    {
        $pagerfantaAdapterMock = $this->createMock(AdapterInterface::class);

        $pagerfantaAdapterMock
            ->expects(self::any())
            ->method('getNbResults')
            ->willReturn(15);

        $pagerfantaAdapterMock
            ->expects(self::any())
            ->method('getSlice')
            ->with(self::identicalTo(8), self::identicalTo(2))
            ->willReturn(new ArrayIterator([new Section(42, 'blog'), new Section(43, 'news')]));

        $this->sectionRepositoryMock
            ->expects(self::once())
            ->method('createListPaginator')
            ->with(self::identicalTo('en'))
            ->willReturn(new Pagerfanta($pagerfantaAdapterMock));

        $items = $this->backend->getSubItems(
            new RootLocation(),
            8,
            2,
        );

        self::assertCount(2, $items);
        self::assertContainsOnlyInstancesOf(Item::class, $items);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::getSubItemsCount
     */
    public function testGetSubItemsCount(): void
    {
        $pagerfantaAdapterMock = $this->createMock(AdapterInterface::class);
        $pagerfantaAdapterMock
            ->expects(self::any())
            ->method('getNbResults')
            ->willReturn(2);

        $this->sectionRepositoryMock
            ->expects(self::once())
            ->method('createListPaginator')
            ->with(self::identicalTo('en'))
            ->willReturn(new Pagerfanta($pagerfantaAdapterMock));

        $count = $this->backend->getSubItemsCount(
            new RootLocation(),
        );

        self::assertSame(2, $count);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::buildItem
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::buildItems
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::searchItems
     */
    public function testSearchItems(): void
    {
        $pagerfantaAdapterMock = $this->createMock(AdapterInterface::class);
        $pagerfantaAdapterMock
            ->expects(self::any())
            ->method('getSlice')
            ->with(self::identicalTo(0), self::identicalTo(25))
            ->willReturn(new ArrayIterator([new Section(42, 'blog'), new Section(43, 'news')]));

        $this->sectionRepositoryMock
            ->expects(self::once())
            ->method('createSearchPaginator')
            ->with(self::identicalTo('test'), self::identicalTo('en'))
            ->willReturn(new Pagerfanta($pagerfantaAdapterMock));

        $searchResult = $this->backend->searchItems(new SearchQuery('test'));

        self::assertCount(2, $searchResult->getResults());
        self::assertContainsOnlyInstancesOf(Item::class, $searchResult->getResults());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::buildItem
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::buildItems
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::searchItems
     */
    public function testSearchItemsWithOffsetAndLimit(): void
    {
        $pagerfantaAdapterMock = $this->createMock(AdapterInterface::class);

        $pagerfantaAdapterMock
            ->expects(self::any())
            ->method('getNbResults')
            ->willReturn(15);

        $pagerfantaAdapterMock
            ->expects(self::any())
            ->method('getSlice')
            ->with(self::identicalTo(8), self::identicalTo(2))
            ->willReturn(new ArrayIterator([new Section(42, 'blog'), new Section(43, 'news')]));

        $this->sectionRepositoryMock
            ->expects(self::once())
            ->method('createSearchPaginator')
            ->with(self::identicalTo('test'), self::identicalTo('en'))
            ->willReturn(new Pagerfanta($pagerfantaAdapterMock));

        $searchQuery = new SearchQuery('test');
        $searchQuery->setOffset(8);
        $searchQuery->setLimit(2);

        $searchResult = $this->backend->searchItems($searchQuery);

        self::assertCount(2, $searchResult->getResults());
        self::assertContainsOnlyInstancesOf(Item::class, $searchResult->getResults());
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::searchItemsCount
     */
    public function testSearchItemsCount(): void
    {
        $pagerfantaAdapterMock = $this->createMock(AdapterInterface::class);
        $pagerfantaAdapterMock
            ->expects(self::any())
            ->method('getNbResults')
            ->willReturn(2);

        $this->sectionRepositoryMock
            ->expects(self::once())
            ->method('createSearchPaginator')
            ->with(self::identicalTo('test'), self::identicalTo('en'))
            ->willReturn(new Pagerfanta($pagerfantaAdapterMock));

        $count = $this->backend->searchItemsCount(new SearchQuery('test'));

        self::assertSame(2, $count);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::buildItem
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::buildItems
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::search
     */
    public function testSearch(): void
    {
        $pagerfantaAdapterMock = $this->createMock(AdapterInterface::class);
        $pagerfantaAdapterMock
            ->expects(self::any())
            ->method('getSlice')
            ->with(self::identicalTo(0), self::identicalTo(25))
            ->willReturn(new ArrayIterator([new Section(42, 'blog'), new Section(43, 'news')]));

        $this->sectionRepositoryMock
            ->expects(self::once())
            ->method('createSearchPaginator')
            ->with(self::identicalTo('test'), self::identicalTo('en'))
            ->willReturn(new Pagerfanta($pagerfantaAdapterMock));

        $items = $this->backend->search('test');

        self::assertCount(2, $items);
        self::assertContainsOnlyInstancesOf(Item::class, $items);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::buildItem
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::buildItems
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::search
     */
    public function testSearchWithOffsetAndLimit(): void
    {
        $pagerfantaAdapterMock = $this->createMock(AdapterInterface::class);

        $pagerfantaAdapterMock
            ->expects(self::any())
            ->method('getNbResults')
            ->willReturn(15);

        $pagerfantaAdapterMock
            ->expects(self::any())
            ->method('getSlice')
            ->with(self::identicalTo(8), self::identicalTo(2))
            ->willReturn(new ArrayIterator([new Section(42, 'blog'), new Section(43, 'news')]));

        $this->sectionRepositoryMock
            ->expects(self::once())
            ->method('createSearchPaginator')
            ->with(self::identicalTo('test'), self::identicalTo('en'))
            ->willReturn(new Pagerfanta($pagerfantaAdapterMock));

        $items = $this->backend->search('test', 8, 2);

        self::assertCount(2, $items);
        self::assertContainsOnlyInstancesOf(Item::class, $items);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend\SectionBackend::searchCount
     */
    public function testSearchCount(): void
    {
        $pagerfantaAdapterMock = $this->createMock(AdapterInterface::class);
        $pagerfantaAdapterMock
            ->expects(self::any())
            ->method('getNbResults')
            ->willReturn(2);

        $this->sectionRepositoryMock
            ->expects(self::once())
            ->method('createSearchPaginator')
            ->with(self::identicalTo('test'), self::identicalTo('en'))
            ->willReturn(new Pagerfanta($pagerfantaAdapterMock));

        $count = $this->backend->searchCount('test');

        self::assertSame(2, $count);
    }
}
