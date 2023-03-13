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

final class BitBagEntityField
{
    private const CONTENT_FIELD_IDENTIFIER = 'content';

    private BitBagEntityFieldType $type;

    private function __construct(private mixed $value)
    {
        $this->type = $this->resolveType($this->value);
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

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function getType(): BitBagEntityFieldType
    {
        return $this->type;
    }

    public function isEmpty(): bool
    {
        return $this->value === null;
    }

    private function resolveType(mixed $value): BitBagEntityFieldType
    {
        return match (true) {
            $value instanceof DateTimeInterface => BitBagEntityFieldType::DATETIME,
            is_string($value) => BitBagEntityFieldType::STRING,
            is_numeric($value) => BitBagEntityFieldType::NUMBER,
            is_bool($value) => BitBagEntityFieldType::BOOLEAN,
            $value instanceof MediaInterface => BitBagEntityFieldType::MEDIA,
            $value instanceof ContentableInterface => BitBagEntityFieldType::CONTENT,
            default => BitBagEntityFieldType::OTHER,
        };
    }
}
