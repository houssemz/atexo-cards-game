<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Card;
use App\GameRule\CardConfig;

final readonly class HandService implements HandServiceInterface
{
    public function __construct(private CardConfig $cardConfig)
    {
    }

    /**
     * @return array<Card>
     */
    #[\Override]
    public function getHand(int $cardsNumber): array
    {
        $hand = [];

        $colors = $this->cardConfig->getColorsOrder();
        $values = $this->cardConfig->getValuesOrder();

        for ($i = 0; $i < $cardsNumber; ++$i) {
            $color = $colors[array_rand($colors)];
            $number = $values[array_rand($values)];

            $hand[] = new Card($color, $number);
        }

        return $hand;
    }

    /**
     * @template ArrayCard array<string, string>
     *
     * @param array<ArrayCard> $cards
     */
    #[\Override]
    public function sortHand(array $cards): array
    {
        $colorOrder = $this->cardConfig->getColorsOrder();
        $valueOrder = $this->cardConfig->getValuesOrder();

        // Custom comparison function for cards sorting
        $sort = function (Card $card1, Card $card2) use ($colorOrder, $valueOrder) {
            // Compare colors
            $colorIndex1 = array_search($card1->getColor(), $colorOrder);
            $colorIndex2 = array_search($card2->getColor(), $colorOrder);
            if ($colorIndex1 !== $colorIndex2) {
                return $colorIndex1 - $colorIndex2;
            }

            // If colors are the same, compare values
            return array_search($card1->getValue(), $valueOrder) - array_search($card2->getValue(), $valueOrder);
        };

        usort($cards, $sort);

        return $cards;
    }
}
