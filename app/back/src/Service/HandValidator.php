<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Card;

final readonly class HandValidator implements HandValidatorInterface
{
    /**
     * @throws \JsonException
     */
    #[\Override]
    public function validate(string $jsonHand): array
    {
        $cards = json_decode($jsonHand, true, flags: \JSON_THROW_ON_ERROR);

        $hand = [];
        foreach ($cards as $card) {
            if (!isset($card['color']) || !isset($card['value'])) {
                throw new \LogicException('Every Card should have a color and a value to can tree hand');
            }

            $hand[] = new Card($card['color'], $card['value']);
        }

        return $hand;
    }
}
