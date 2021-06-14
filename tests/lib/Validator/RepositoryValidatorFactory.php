<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Validator;

use Netgen\Layouts\Sylius\BitBag\Repository\PageRepositoryInterface;
use Netgen\Layouts\Sylius\BitBag\Repository\SectionRepositoryInterface;
use Netgen\Layouts\Sylius\BitBag\Validator\PageValidator;
use Netgen\Layouts\Sylius\BitBag\Validator\SectionValidator;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorFactory;
use Symfony\Component\Validator\ConstraintValidatorFactoryInterface;

final class RepositoryValidatorFactory implements ConstraintValidatorFactoryInterface
{
    private RepositoryInterface $repository;

    private ConstraintValidatorFactory $baseValidatorFactory;

    public function __construct(RepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->baseValidatorFactory = new ConstraintValidatorFactory();
    }

    public function getInstance(Constraint $constraint)
    {
        $name = $constraint->validatedBy();

        if ($name === 'nglayouts_sylius_bitbag_page' && $this->repository instanceof PageRepositoryInterface) {
            return new PageValidator($this->repository);
        }

        if ($name === 'nglayouts_sylius_bitbag_section' && $this->repository instanceof SectionRepositoryInterface) {
            return new SectionValidator($this->repository);
        }

        return $this->baseValidatorFactory->getInstance($constraint);
    }
}