<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Validator;

use BitBag\SyliusCmsPlugin\Repository\PageRepositoryInterface;
use Netgen\Layouts\Sylius\BitBag\Tests\Stubs\Page as PageStub;
use Netgen\Layouts\Sylius\BitBag\Validator\Constraint\Page;
use Netgen\Layouts\Sylius\BitBag\Validator\PageValidator;
use Netgen\Layouts\Tests\TestCase\ValidatorTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class PageValidatorTest extends ValidatorTestCase
{
    private MockObject&PageRepositoryInterface $repositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->constraint = new Page();
    }

    public function getValidator(): ConstraintValidatorInterface
    {
        $this->repositoryMock = $this->createMock(PageRepositoryInterface::class);

        return new PageValidator($this->repositoryMock);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Validator\PageValidator::__construct
     * @covers \Netgen\Layouts\Sylius\BitBag\Validator\PageValidator::validate
     */
    public function testValidateValid(): void
    {
        $this->repositoryMock
            ->expects(self::once())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn(new PageStub(42, 'contact-us'));

        $this->assertValid(true, 42);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Validator\PageValidator::__construct
     * @covers \Netgen\Layouts\Sylius\BitBag\Validator\PageValidator::validate
     */
    public function testValidateNull(): void
    {
        $this->repositoryMock
            ->expects(self::never())
            ->method('find');

        $this->assertValid(true, null);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Validator\PageValidator::__construct
     * @covers \Netgen\Layouts\Sylius\BitBag\Validator\PageValidator::validate
     */
    public function testValidateInvalid(): void
    {
        $this->repositoryMock
            ->expects(self::once())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn(null);

        $this->assertValid(false, 42);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Validator\PageValidator::validate
     */
    public function testValidateThrowsUnexpectedTypeExceptionWithInvalidConstraint(): void
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "Netgen\\Layouts\\Sylius\\BitBag\\Validator\\Constraint\\Page", "Symfony\\Component\\Validator\\Constraints\\NotBlank" given');

        $this->constraint = new NotBlank();
        $this->assertValid(true, 'value');
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Validator\PageValidator::validate
     */
    public function testValidateThrowsUnexpectedTypeExceptionWithInvalidValue(): void
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "scalar", "array" given');

        $this->assertValid(true, []);
    }
}
