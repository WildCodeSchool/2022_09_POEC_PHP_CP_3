<?php

namespace App\Service;
use App\Entity\Boat;
use App\Entity\Tile;
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

    public function getRandomIsland(): Tile
    {
        $islands = $this->tileRepository->findBy(['type' => 'island']);
        return $islands[array_rand($islands)];
    }

    public function checkTreasure(Boat $boat): bool
    {
        return $this->tileRepository->findOneBy([
            'coordX' => $boat->getCoordX(),
            'coordY' => $boat->getCoordY()
        ])->hasTreasure();
    }
}