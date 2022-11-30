<?php

namespace App\Service;

use App\Repository\TileRepository;
use App\Entity\Tile;

class MapManager
{

    public function __construct(private TileRepository $tileRepository){

    }

    public function tileExists(int $x, int $y): bool
    {
        $tiles = $this->tileRepository->findAll();
        $X =[];
        $Y =[];
        foreach ($tiles as $tile) {
          # code...
          $a= $tile->getCoordX();
          $X[] = $a;
          $b = $tile->getCoordY();
          $Y[] = $b;
        }

        if (in_array($x, $X) && in_array($y, $Y)) {
          return true;
        }else{
          return false;
        }

    }

    public function getRandomIsland(array $tiles): Tile
    {
      $islands= [];
      foreach ($tiles as $tile) {
        if($tile->getType() === 'island'){
          $islands[] = $tile;
        }
      }
      $tresor = array_rand($islands, 1);
      $islandTreasure = $islands[$tresor]->setHasTreasure(true);
      return $islandTreasure;

    }
}
