<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Item\ValueLoader;

use BitBag\SyliusCmsPlugin\Entity\SectionInterface;
use Netgen\Layouts\Item\ValueLoaderInterface;
use Netgen\Layouts\Sylius\BitBag\Repository\SectionRepositoryInterface;
use Throwable;

final class SectionValueLoader implements ValueLoaderInterface
{
    private SectionRepositoryInterface $sectionRepository;

    public function __construct(SectionRepositoryInterface $sectionRepository)
    {
        $this->sectionRepository = $sectionRepository;
    }

    public function load($id): ?SectionInterface
    {
        try {
            $section = $this->sectionRepository->find($id);
        } catch (Throwable $t) {
            return null;
        }

        return $section instanceof SectionInterface ? $section : null;
    }

    public function loadByRemoteId($remoteId): ?SectionInterface
    {
        return $this->load($remoteId);
    }
}
