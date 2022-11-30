<?php

namespace App\Service;

use App\Repository\TileRepository;

class MapManager
{

    public function tileExists(int $x, int $y, TileRepository $tileRepository): bool
    {
        $tiles = $tileRepository->findAll();
        foreach ($tiles as $tile) {
            if (($tile->getCoordX() == $x) && ($tile->getCoordY() == $y)) {
                return true;
            }
        }
    }
}
