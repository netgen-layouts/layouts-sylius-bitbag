<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Item\ValueLoader;

use BitBag\SyliusCmsPlugin\Entity\FrequentlyAskedQuestionInterface;
use Netgen\Layouts\Item\ValueLoaderInterface;
use Netgen\Layouts\Sylius\BitBag\Repository\FrequentlyAskedQuestionRepositoryInterface;
use Throwable;

final class FrequentlyAskedQuestionValueLoader implements ValueLoaderInterface
{
    public function __construct(private FrequentlyAskedQuestionRepositoryInterface $frequentlyAskedQuestionRepository)
    {
    }

    public function load($id): ?FrequentlyAskedQuestionInterface
    {
        try {
            $frequentlyAskedQuestion = $this->frequentlyAskedQuestionRepository->find($id);
        } catch (Throwable) {
            return null;
        }

        return $frequentlyAskedQuestion instanceof FrequentlyAskedQuestionInterface ? $frequentlyAskedQuestion : null;
    }

    public function loadByRemoteId($remoteId): ?FrequentlyAskedQuestionInterface
    {
        return $this->load($remoteId);
    }
}
