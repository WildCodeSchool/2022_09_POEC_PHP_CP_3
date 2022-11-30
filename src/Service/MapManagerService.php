<?php

namespace App\Service;

use App\Repository\TileRepository;

class MapManagerService
{
    public function __construct(private TileRepository $boat)
    {
        
    }
    public function tileExists(int $x, int $y): bool
    {
        return $this->boat->findOneBy(['coordX' => $x, 'coordY' => $y])!==null;
    }
}