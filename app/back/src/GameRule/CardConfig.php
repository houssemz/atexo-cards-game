<?php

declare(strict_types=1);

namespace App\GameRule;

final class CardConfig
{
    private array $colorsOrder = ['Carreaux', 'Coeur', 'Pique', 'Trefle'];
    private array $valuesOrder = ['As', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Valet', 'Dame', 'Roi'];

    public function getColorsOrder(): array
    {
        return $this->colorsOrder;
    }

    public function getValuesOrder(): array
    {
        return $this->valuesOrder;
    }
}
