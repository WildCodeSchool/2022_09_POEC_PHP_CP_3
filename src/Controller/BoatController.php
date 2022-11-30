<?php

namespace App\Controller;

use App\Entity\Boat;
use App\Repository\BoatRepository;
use App\Service\MapManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/boat')]
class BoatController extends AbstractController
{
    #[Route('/move/{x}/{y}', name: 'moveBoat', requirements: ['x' => '\d+', 'y' => '\d+'])]
    public function moveBoat(int $x, int $y, BoatRepository $boatRepository, EntityManagerInterface $em): Response
    {
        $boat = $boatRepository->findOneBy([]);
        $boat->setCoordX($x);
        $boat->setCoordY($y);
        $em->flush();
        return $this->redirectToRoute('map');
    }

    #[Route('/move/direction/{direction}', name: 'moveDirection', requirements: ['direction' => '^[NSEW]$'])]
    public function moveDirection(
        string $direction,
        BoatRepository $boatRepository,
        EntityManagerInterface $em,
        MapManager $mapManager
    ): Response {
        $boat = $boatRepository->findOneBy([]);
        $x = $boat->getCoordX();
        $y = $boat->getCoordY();

        switch ($direction) {
            case "N":
                $y--;
                break;
            case "S":
                $y++;
                break;
            case "E":
                $x++;
                break;
            case "W":
                $x--;
                break;
        }

        if ($mapManager->tileExists($x, $y)) {
            $boat->setCoordX($x);
            $boat->setCoordY($y);
            $em->flush();

            if ($mapManager->checkTreasure($boat)) {
                $this->addFlash('success', 'You found the treasure.');
            }
        } else {
            $this->addFlash('danger', 'This tile doesn\'t exist');
        }

        return $this->redirectToRoute("map");
    }
}

