<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\ContentBrowser\Backend;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use Netgen\ContentBrowser\Backend\BackendInterface;
use Netgen\ContentBrowser\Backend\SearchQuery;
use Netgen\ContentBrowser\Backend\SearchResult;
use Netgen\ContentBrowser\Backend\SearchResultInterface;
use Netgen\ContentBrowser\Exceptions\NotFoundException;
use Netgen\ContentBrowser\Item\LocationInterface;
use Netgen\Layouts\Browser\Item\Layout\RootLocation;
use Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Media\Item;
use Netgen\Layouts\Sylius\BitBag\Repository\MediaRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;

use function max;
use function sprintf;

final class MediaBackend implements BackendInterface
{
    public function __construct(
        private MediaRepositoryInterface $mediaRepository,
        private LocaleContextInterface $localeContext,
    ) {}

    public function getSections(): iterable
    {
        return [new RootLocation()];
    }

    public function loadLocation($id): RootLocation
    {
        return new RootLocation();
    }

    public function loadItem($value): Item
    {
        $media = $this->mediaRepository->find($value);

        if (!$media instanceof MediaInterface) {
            throw new NotFoundException(
                sprintf(
                    'Item with value "%s" not found.',
                    $value,
                ),
            );
        }

        return $this->buildItem($media);
    }

    public function getSubLocations(LocationInterface $location): iterable
    {
        return [];
    }

    public function getSubLocationsCount(LocationInterface $location): int
    {
        return 0;
    }

    public function getSubItems(LocationInterface $location, int $offset = 0, int $limit = 25): iterable
    {
        $paginator = $this->mediaRepository->createListPaginator(
            $this->localeContext->getLocaleCode(),
        );

        $limit = max(0, $limit);
        $offset = max(0, $offset);

        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage((int) ($offset / $limit) + 1);

        return $this->buildItems(
            $paginator->getAdapter()->getSlice($offset, $limit),
        );
    }

    public function getSubItemsCount(LocationInterface $location): int
    {
        $paginator = $this->mediaRepository->createListPaginator(
            $this->localeContext->getLocaleCode(),
        );

        return $paginator->getNbResults();
    }

    public function searchItems(SearchQuery $searchQuery): SearchResultInterface
    {
        $paginator = $this->mediaRepository->createSearchPaginator(
            $searchQuery->getSearchText(),
            $this->localeContext->getLocaleCode(),
        );

        $paginator->setMaxPerPage($searchQuery->getLimit());
        $paginator->setCurrentPage((int) ($searchQuery->getOffset() / $searchQuery->getLimit()) + 1);

        return new SearchResult(
            $this->buildItems(
                $paginator->getCurrentPageResults(),
            ),
        );
    }

    public function searchItemsCount(SearchQuery $searchQuery): int
    {
        $paginator = $this->mediaRepository->createSearchPaginator(
            $searchQuery->getSearchText(),
            $this->localeContext->getLocaleCode(),
        );

        return $paginator->getNbResults();
    }

    public function search(string $searchText, int $offset = 0, int $limit = 25): iterable
    {
        $searchQuery = new SearchQuery($searchText);
        $searchQuery->setOffset($offset);
        $searchQuery->setLimit($limit);

        $searchResult = $this->searchItems($searchQuery);

        return $searchResult->getResults();
    }

    public function searchCount(string $searchText): int
    {
        return $this->searchItemsCount(new SearchQuery($searchText));
    }

    /**
     * Builds the item from provided media.
     */
    private function buildItem(MediaInterface $media): Item
    {
        return new Item($media);
    }

    /**
     * Builds the items from provided medias.
     *
     * @param iterable<\BitBag\SyliusCmsPlugin\Entity\MediaInterface> $medias
     *
     * @return \Netgen\Layouts\Sylius\BitBag\ContentBrowser\Item\Media\Item[]
     */
    private function buildItems(iterable $medias): array
    {
        $items = [];

        foreach ($medias as $media) {
            $items[] = $this->buildItem($media);
        }

        return $items;
    }
}
