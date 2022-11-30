<?php

namespace App\Service;

use App\Repository\TileRepository;

class MapManager
{
    public function __construct(private TileRepository $tileRepository)
    {
    }

    public function tileExists(int $x, int $y): bool
    {
        return $this->tileRepository->findOneBy(['coordX' => $x, 'coordY' => $y]) !== null;
    }
}
