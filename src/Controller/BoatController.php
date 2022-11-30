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
    #[Route('/direction/{direction}', name: 'moveDirection', requirements: ['direction' => '/|N|S|E|W|/i'])]
    public function moveDirection(string $direction, BoatRepository $boatRepository, EntityManagerInterface $em): Response
    {
        $boat = $boatRepository->findOneBy([]);
        $x = $boat->getCoordX();
        $y = $boat->getCoordY();

        if($direction === 'E'){
            $x = $x +1;
            
        }
        elseif($direction==='W'){
            $x = $x -1;
            
        }
        elseif($direction==='N'){
            $y = $y -1;
        
        }
        elseif($direction==='S'){
            $y = $y +1;
            
        }

        $boat->setCoordX($x);
        $boat->setCoordY($y);

        $em->flush();
        return $this->redirectToRoute('map');
    }
}
