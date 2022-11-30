<?php

namespace App\Service;

use App\Repository\BoatRepository;
use App\Repository\TileRepository;

class PositionDisplay
{
    public function __construct(private BoatRepository $boatRepository, private TileRepository $tileRepository)
    {
    }

    public function displayPosition(BoatRepository $boatRepository, TileRepository $tileRepository)
    {
        $boat = $boatRepository->findOneBy([]);
        $boatPosX = $boat->getCoordX();
        $boatPosY = $boat->getCoordY();


        // return $this->render('map/index.html.twig', [
        //     'boatPosX' => $boatPosX,
        //     'boatPosY' => $boatPosY,
        // ]);
    }

    public function getTileType(string $x, string $y, ?TileRepository $tileRepository)
    {
        $tile = $tileRepository->findOneBy([[$x, $y]]);
        $type = $tile->getType();
    }
}
