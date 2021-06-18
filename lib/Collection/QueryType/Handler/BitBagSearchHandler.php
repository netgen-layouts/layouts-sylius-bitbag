<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Collection\QueryType\Handler;

use Netgen\Layouts\API\Values\Collection\Query;
use Netgen\Layouts\Collection\QueryType\QueryTypeHandlerInterface;
use Netgen\Layouts\Parameters\ParameterBuilderInterface;
use Netgen\Layouts\Parameters\ParameterType;
use Netgen\Layouts\Sylius\BitBag\Repository\BlockRepositoryInterface;
use Netgen\Layouts\Sylius\BitBag\Repository\MediaRepositoryInterface;
use Netgen\Layouts\Sylius\BitBag\Repository\PageRepositoryInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Resource\Repository\RepositoryInterface;

final class BitBagSearchHandler implements QueryTypeHandlerInterface
{
    private PageRepositoryInterface $pageRepository;

    private BlockRepositoryInterface $blockRepository;

    private MediaRepositoryInterface $mediaRepository;

    private LocaleContextInterface $localeContext;

    public function __construct(
        PageRepositoryInterface $pageRepository,
        BlockRepositoryInterface $blockRepository,
        MediaRepositoryInterface $mediaRepository,
        LocaleContextInterface $localeContext
    ) {
        $this->pageRepository = $pageRepository;
        $this->blockRepository = $blockRepository;
        $this->mediaRepository = $mediaRepository;
        $this->localeContext = $localeContext;
    }

    public function buildParameters(ParameterBuilderInterface $builder): void
    {
        $builder->add(
            'bitbag_item_type',
            ParameterType\ChoiceType::class,
            [
                'required' => true,
                'options' => [
                    'BitBag page' => 'page',
                    'BitBag block' => 'block',
                    'BitBag media' => 'media',
                ],
            ],
        );
    }

    public function getValues(Query $query, int $offset = 0, ?int $limit = null): iterable
    {
        $repository = $this->resolveRepository($query);

        if (!$repository instanceof RepositoryInterface) {
            return [];
        }

        $paginator = $repository->createListPaginator(
            $this->localeContext->getLocaleCode(),
        );

        $paginator->setMaxPerPage($limit);
        $paginator->setCurrentPage((int) ($offset / $limit) + 1);

        return $paginator->getCurrentPageResults();
    }

    public function getCount(Query $query): int
    {
        $repository = $this->resolveRepository($query);

        if (!$repository instanceof RepositoryInterface) {
            return 0;
        }

        $paginator = $repository->createListPaginator(
            $this->localeContext->getLocaleCode(),
        );

        return $paginator->getNbResults();
    }

    public function isContextual(Query $query): bool
    {
        return false;
    }

    private function resolveRepository(Query $query): ?RepositoryInterface
    {
        $bitBagItemType = $query->getParameter('bitbag_item_type')->getValue();

        switch ($bitBagItemType) {
            case 'page':
                return $this->pageRepository;

            case 'block':
                return $this->blockRepository;

            case 'media':
                return $this->mediaRepository;

            default:
                return null;
        }
    }
}
