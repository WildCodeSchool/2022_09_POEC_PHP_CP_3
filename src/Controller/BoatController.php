<?php

namespace App\Controller;

use App\Repository\BoatRepository;
use App\Service\MapManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    #[Route('/direction/{direction}', name: 'moveDirection', requirements: ['direction' => '[NSEW]'])]
    public function moveDirection(string $direction, BoatRepository $boatRepository, EntityManagerInterface $em, MapManager $mapManager): Response
    {
        $boat = $boatRepository->findOneBy([]);

        $x = $boat->getCoordX();
        $y = $boat->getCoordY();
        switch ($direction) {
            case 'N':
                $boat->setCoordY($y - 1);
                break;
            case 'S':
                $boat->setCoordY($y + 1);
                break;
            case 'W':
                $boat->setCoordX($x - 1);
                break;
            case 'E':
                $boat->setCoordX($x + 1);
                break;
            default:
                //404
        }

        if ($mapManager->tileExists($boat->getCoordX(), $boat->getCoordY())) {
            $em->persist($boat);
            $em->flush();
        } else {
            $this->addFlash('alert', 'You are out of the map area !');
        }
        return $this->redirectToRoute('map');
    }
}
