<?php

Namespace App\Service;
use App\Entity\Tile;
use App\Repository\TileRepository;

class MapManager {

    public function __construct(private TileRepository $tileRepository) {

    }

public function tileExists($x, $y): bool 
{      if($y > -1 && $y < 5 && $x > -1 && $x < 12){
        return true;

        } else{

        return false;
    }
}

public function getRandomIsland( array $tiles): Tile
{   $islands = [];
    foreach ($tiles as $tile) {
        if ($tile->getType() === 'island') {
        $islands[] = $tile;
    }
    }
    $TreasureIsland = array_rand($islands, 1);
    $islands[$TreasureIsland]->setHasTreasure(true);
    return $islands[$TreasureIsland];
}
}
