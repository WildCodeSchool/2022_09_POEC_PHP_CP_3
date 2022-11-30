<?php

namespace App\Controller;

use App\Entity\Boat;
use App\Repository\BoatRepository;
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

    #[Route('/direction/{coordinate}', name: 'moveDirection', requirements: ['coordinate' => '/|N|S|E|W|/i'])]
    public function moveDirection(BoatRepository $boatRepository, EntityManagerInterface $em, string $coordinate): Response
    {
        $boat = $boatRepository->findOneBy([]);

        switch ($coordinate) {
            case 'N':
                $boat->setCoordY($boat->getCoordY() - 1);
                break;
            case 'S':
                $boat->setCoordY($boat->getCoordY() + 1);
                break;
            case 'E':
                $boat->setCoordX($boat->getCoordX() + 1);
                break;
            case 'W':
                $boat->setCoordX($boat->getCoordX() - 1);
                break;
        }
        $em->flush();
        return $this->redirectToRoute('map');
    }
}
