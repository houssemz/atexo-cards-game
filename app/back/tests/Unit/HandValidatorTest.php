<?php

declare(strict_types=1);

namespace Unit;

use App\Entity\Card;
use App\Service\HandValidator;
use PHPUnit\Framework\TestCase;

final class HandValidatorTest extends TestCase
{
    /**
     * @throws \JsonException
     */
    public function testValidateAValidJsonHand(): void
    {
        // Given
        $jsonHand = <<<JSON
                [
                  {
                    "color": "Carreaux",
                    "value": "4"
                  },
                  {
                    "color": "Coeur",
                    "value": "5"
                  }
                ]
            JSON;

        $expectedHand = [
            new Card('Carreaux', '4'),
            new Card('Coeur', '5'),
        ];

        // When
        $handValidator = new HandValidator();
        $result = $handValidator->validate($jsonHand);

        // Then
        $this->assertEquals($expectedHand, $result);
    }

    /**
     * @throws \JsonException
     */
    public function testValidateAnInvalidJsonHand(): void
    {
        // Given missing 'value' for first card
        $jsonHand = <<<JSON
                [
                  {
                    "color": "Carreaux"
                  },
                  {
                    "color": "Coeur",
                    "value": "5"
                  }
                ]
            JSON;

        // When
        $handValidator = new HandValidator();

        // Then
        $this->expectException(\LogicException::class);
        $handValidator->validate($jsonHand);

        // Given missing 'color' for second card
        $jsonHand = <<<JSON
                [
                  {
                    "color": "Carreaux",
                    "value": "5"
                  },
                  {
                    "value": "As"
                  }
                ]
            JSON;

        // When
        $handValidator = new HandValidator();

        // Then
        $this->expectException(\LogicException::class);
        $handValidator->validate($jsonHand);
    }
}
