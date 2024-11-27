<?php

declare(strict_types=1);

namespace ProjetNormandie\PageBundle\ValueObject;

use Webmozart\Assert\Assert;

class PageStatus
{
    public const string PUBLIC = 'PUBLIC';
    public const string PRIVATE = 'PRIVATE';

    public const array VALUES = [
        self::PUBLIC,
        self::PRIVATE,
    ];

    private string $value;

    public function __construct(string $value)
    {
        self::inArray($value);

        $this->value = $value;
    }

    public static function inArray(string $value): void
    {
        Assert::inArray($value, self::VALUES);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public function isPrivate(): bool
    {
        return self::PRIVATE === $this->value;
    }

    public function isPublic(): bool
    {
        return self::PUBLIC === $this->value;
    }

    public static function getStatusChoices(): array
    {
        return [
            self::PRIVATE  => self::PRIVATE,
            self::PUBLIC  => self::PUBLIC,
        ];
    }
}
