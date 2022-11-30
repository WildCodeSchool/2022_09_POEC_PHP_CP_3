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
    
    #[Route('/direction/{direction}', name: 'directionBoat', requirements: ['direction' => 'N|S|E|W'])]
    public function directionBoat(string $direction, BoatRepository $boatRepository, EntityManagerInterface $em): Response
    {
        $boat = $boatRepository->findOneBy([]);
        $boat->setDirection($direction);
        
        switch ($direction) {
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
