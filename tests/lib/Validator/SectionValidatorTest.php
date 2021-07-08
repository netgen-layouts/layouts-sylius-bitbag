<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Tests\Validator;

use BitBag\SyliusCmsPlugin\Repository\SectionRepositoryInterface;
use Netgen\Layouts\Sylius\BitBag\Tests\Stubs\Section as SectionStub;
use Netgen\Layouts\Sylius\BitBag\Validator\Constraint\Section;
use Netgen\Layouts\Sylius\BitBag\Validator\SectionValidator;
use Netgen\Layouts\Tests\TestCase\ValidatorTestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;

final class SectionValidatorTest extends ValidatorTestCase
{
    private MockObject $repositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        $this->constraint = new Section();
    }

    public function getValidator(): ConstraintValidatorInterface
    {
        $this->repositoryMock = $this->createMock(SectionRepositoryInterface::class);

        return new SectionValidator($this->repositoryMock);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Validator\SectionValidator::__construct
     * @covers \Netgen\Layouts\Sylius\BitBag\Validator\SectionValidator::validate
     */
    public function testValidateValid(): void
    {
        $this->repositoryMock
            ->expects(self::once())
            ->method('find')
            ->with(self::identicalTo(42))
            ->willReturn(new SectionStub(42, 'blog'));

        $this->assertValid(true, 42);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Validator\SectionValidator::__construct
     * @covers \Netgen\Layouts\Sylius\BitBag\Validator\SectionValidator::validate
     */
    public function testValidateNull(): void
    {
        $this->repositoryMock
            ->expects(self::never())
            ->method('find');

        $this->assertValid(true, null);
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Validator\SectionValidator::__construct
     * @covers \Netgen\Layouts\Sylius\BitBag\Validator\SectionValidator::validate
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
     * @covers \Netgen\Layouts\Sylius\BitBag\Validator\SectionValidator::validate
     */
    public function testValidateThrowsUnexpectedTypeExceptionWithInvalidConstraint(): void
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "Netgen\\Layouts\\Sylius\\BitBag\\Validator\\Constraint\\Section", "Symfony\\Component\\Validator\\Constraints\\NotBlank" given');

        $this->constraint = new NotBlank();
        $this->assertValid(true, 'value');
    }

    /**
     * @covers \Netgen\Layouts\Sylius\BitBag\Validator\SectionValidator::validate
     */
    public function testValidateThrowsUnexpectedTypeExceptionWithInvalidValue(): void
    {
        $this->expectException(UnexpectedTypeException::class);
        $this->expectExceptionMessage('Expected argument of type "scalar", "array" given');

        $this->assertValid(true, []);
    }
}
