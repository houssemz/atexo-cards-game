<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Card;

interface HandValidatorInterface
{
    /**
     * @return array<Card>
     */
    public function validate(string $jsonHand): array;
}
