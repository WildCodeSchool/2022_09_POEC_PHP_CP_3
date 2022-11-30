<?php

namespace App\Service;

class MapManager
{
    //Utiliser le max de TileRepository au lieu de hardcoder les valeurs de max et min
    public function tileExists(int $x, int $y): bool
    {
        if ($x < 0 || $x > 11) {
            return false;
        };
        if ($y < 0 || $y > 5) {
            return false;
        }
        return true;
    }
}
