<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Item\ValueLoader;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use Netgen\Layouts\Item\ValueLoaderInterface;
use Netgen\Layouts\Sylius\BitBag\Repository\BlockRepositoryInterface;
use Throwable;

final class BlockValueLoader implements ValueLoaderInterface
{
    private BlockRepositoryInterface $blockRepository;

    public function __construct(BlockRepositoryInterface $blockRepository)
    {
        $this->blockRepository = $blockRepository;
    }

    public function load($id): ?BlockInterface
    {
        try {
            $block = $this->blockRepository->find($id);
        } catch (Throwable $t) {
            return null;
        }

        return $block instanceof BlockInterface ? $block : null;
    }

    public function loadByRemoteId($remoteId): ?BlockInterface
    {
        return $this->load($remoteId);
    }
}
