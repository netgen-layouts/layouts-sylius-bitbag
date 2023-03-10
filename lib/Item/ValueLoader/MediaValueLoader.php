<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Item\ValueLoader;

use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use Netgen\Layouts\Item\ValueLoaderInterface;
use Netgen\Layouts\Sylius\BitBag\Repository\MediaRepositoryInterface;
use Throwable;

final class MediaValueLoader implements ValueLoaderInterface
{
    public function __construct(private MediaRepositoryInterface $mediaRepository)
    {
    }

    public function load($id): ?MediaInterface
    {
        try {
            $media = $this->mediaRepository->find($id);
        } catch (Throwable) {
            return null;
        }

        return $media instanceof MediaInterface ? $media : null;
    }

    public function loadByRemoteId($remoteId): ?MediaInterface
    {
        return $this->load($remoteId);
    }
}
