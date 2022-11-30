<?php

namespace App\Controller;

use App\Service\MapManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Tile;
use App\Repository\BoatRepository;
use App\Repository\TileRepository;

class MapController extends AbstractController
{
    #[Route('/map', name: 'map')]
    public function displayMap(BoatRepository $boatRepository, TileRepository $tileRepository): Response
    {
        $tiles = $tileRepository->findAll();

        foreach ($tiles as $tile) {
            $map[$tile->getCoordX()][$tile->getCoordY()] = $tile;
        }

        $boat = $boatRepository->findOneBy([]);
        $boatTile = $tileRepository->findOneBy([
            'coordX' => $boat->getCoordX(),
            'coordY' => $boat->getCoordY()
        ]);

        return $this->render('map/index.html.twig', [
            'map'  => $map ?? [],
            'boat' => $boat,
            'boatTile' => $boatTile
        ]);
    }

    #[Route('/start', name: 'start')]
    public function start(
        BoatRepository $boatRepository,
        TileRepository $tileRepository,
        EntityManagerInterface $em,
        MapManager $mapManager
    ): Response {
        $boat = $boatRepository->findOneBy([]);
        $boat->setCoordX(0);
        $boat->setCoordY(0);

        $tileRepository->findOneBy(['hasTreasure' => true])->setHasTreasure(false);
        $mapManager->getRandomIsland()->setHasTreasure(true);

        $em->flush();
        return $this->redirectToRoute('map');
    }
}
