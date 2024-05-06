<?php

declare(strict_types=1);

namespace Unit;

use App\Entity\Card;
use App\GameRule\CardConfig;
use App\Service\HandService;
use PHPUnit\Framework\TestCase;

class HandServiceTest extends TestCase
{
    public function testGetHand(): void
    {
        // Given
        $handService = new HandService(new CardConfig());

        // When
        $hand = $handService->getHand(10);

        // Then
        $this->assertCount(10, $hand);
        foreach ($hand as $card) {
            $this->assertInstanceOf(Card::class, $card);
        }

        // Hand with 15 cards
        // When
        $hand = $handService->getHand(15);

        // Then
        $this->assertCount(15, $hand);
        foreach ($hand as $card) {
            $this->assertInstanceOf(Card::class, $card);
        }
    }

    public function testSortHand(): void
    {
        // Given
        $cardConfig = new CardConfig();
        $handService = new HandService($cardConfig);
        $hand = [
            new Card('Trefle', '10'),
            new Card('Coeur', '5'),
            new Card('Coeur', '4'),
            new Card('Pique', '5'),
            new Card('Trefle', 'As'),
            new Card('Carreaux', '2'),
        ];

        // When
        /** @var Card[] $sortedHand */
        $sortedHand = $handService->sortHand($hand);

        // Then
        $this->assertSame('Carreaux', $sortedHand[0]->getColor());
        $this->assertSame('2', $sortedHand[0]->getValue());

        $this->assertSame('Coeur', $sortedHand[1]->getColor());
        $this->assertSame('4', $sortedHand[1]->getValue());

        $this->assertSame('Coeur', $sortedHand[2]->getColor());
        $this->assertSame('5', $sortedHand[2]->getValue());

        $this->assertSame('Pique', $sortedHand[3]->getColor());
        $this->assertSame('5', $sortedHand[3]->getValue());

        $this->assertSame('Trefle', $sortedHand[4]->getColor());
        $this->assertSame('As', $sortedHand[4]->getValue());

        $this->assertSame('Trefle', $sortedHand[5]->getColor());
        $this->assertSame('10', $sortedHand[5]->getValue());
    }
}
