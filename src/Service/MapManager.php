<?php

namespace App\Service;

use App\Entity\Tile;
use App\Entity\Boat;
use App\Repository\TileRepository;

class MapManager
{
    private TileRepository $tileRepository;
    public function __construct(TileRepository $tileRepository)
    {
        $this->tileRepository = $tileRepository;
    }

    public function tileExists(int $x, int $y): bool
    {
        if ($this->tileRepository->findOneBy(['coordX' => $x, 'coordY' => $y])) {
            return true;
        } else {
            return false;
        }
    }

    public function getRandomIsland(): Tile
    {
        $tilesIsland = $this->tileRepository->findBy(['type'=> 'island']);
        return $tilesIsland[array_rand($tilesIsland)];
    }

    public function checkTreasure(Boat $boat)
    {
        $tile = $this->tileRepository->findOneBy(['coordX'=> $boat->getCoordX(), 'coordY' => $boat->getCoordY()]);
        if ($tile->isHasTreasure()) {
            return true;
        } else {
            return false;
        }
    }
}