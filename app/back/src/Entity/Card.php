<?php

declare(strict_types=1);

namespace App\Entity;

readonly class Card implements \JsonSerializable
{
    public function __construct(private string $color, private string $value)
    {
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    #[\Override]
    public function jsonSerialize(): array
    {
        return ['color' => $this->getColor(), 'value' => $this->getValue()];
    }
}
