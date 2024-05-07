<?php

declare(strict_types=1);

namespace App\Service;

interface HandServiceInterface
{
    public function getHand(int $cardsNumber): array;

    public function sortHand(array $cards): array;
}
