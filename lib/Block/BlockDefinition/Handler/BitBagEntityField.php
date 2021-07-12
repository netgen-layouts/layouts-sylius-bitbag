<?php

declare(strict_types=1);

namespace Netgen\Layouts\Sylius\BitBag\Block\BlockDefinition\Handler;

use BitBag\SyliusCmsPlugin\Entity\ContentableInterface;
use BitBag\SyliusCmsPlugin\Entity\MediaInterface;
use DateTimeInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use function is_bool;
use function is_numeric;
use function is_string;
use function method_exists;
use function ucfirst;

class BitBagEntityField
{
    public const TYPE_STRING = 'string';
    public const TYPE_NUMBER = 'number';
    public const TYPE_MEDIA = 'media';
    public const TYPE_DATETIME = 'datetime';
    public const TYPE_BOOLEAN = 'boolean';
    public const TYPE_OTHER = 'other';
    public const TYPE_CONTENT = 'content';
    private const CONTENT_FIELD_IDENTIFIER = 'content';

    private string $type;

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param mixed $value
     */
    private function __construct($value)
    {
        $this->value = $value;

        if ($value instanceof DateTimeInterface) {
            $this->type = self::TYPE_DATETIME;

            return;
        }

        if (is_string($value)) {
            $this->type = self::TYPE_STRING;

            return;
        }

        if (is_numeric($value)) {
            $this->type = self::TYPE_NUMBER;

            return;
        }

        if (is_bool($value)) {
            $this->type = self::TYPE_BOOLEAN;

            return;
        }

        if ($value instanceof MediaInterface) {
            $this->type = self::TYPE_MEDIA;

            return;
        }

        if ($value instanceof ContentableInterface) {
            $this->type = self::TYPE_CONTENT;

            return;
        }

        $this->type = self::TYPE_OTHER;
    }

    public static function fromBitBagEntity(ResourceInterface $resource, string $fieldIdentifier): self
    {
        if ($resource instanceof ContentableInterface && $fieldIdentifier === self::CONTENT_FIELD_IDENTIFIER) {
            return new self($resource);
        }

        $methodName = 'get' . ucfirst($fieldIdentifier);

        if (method_exists($resource, $methodName)) {
            $value = $resource->{$methodName}();

            return new self($value);
        }

        $methodName = 'is' . ucfirst($fieldIdentifier);

        if (method_exists($resource, $methodName)) {
            $value = $resource->{$methodName}();

            return new self($value);
        }

        return new self(null);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isEmpty(): bool
    {
        return $this->value === null;
    }
}
