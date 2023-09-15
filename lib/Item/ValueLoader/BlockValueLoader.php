<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Item\ValueLoader;

use BitBag\SyliusCmsPlugin\Entity\BlockInterface;
use Netgen\Layouts\Item\ValueLoaderInterface;
use Netgen\Layouts\Sylius\BitBag\Repository\BlockRepositoryInterface;
use Throwable;

final class BlockValueLoader implements ValueLoaderInterface
{
    public function __construct(private BlockRepositoryInterface $blockRepository) {}

    public function load($id): ?BlockInterface
    {
        try {
            $block = $this->blockRepository->find($id);
        } catch (Throwable) {
            return null;
        }

        return $block instanceof BlockInterface ? $block : null;
    }

    public function loadByRemoteId($remoteId): ?BlockInterface
    {
        return $this->load($remoteId);
    }
}
