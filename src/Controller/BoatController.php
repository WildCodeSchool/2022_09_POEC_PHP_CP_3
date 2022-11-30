<?php

namespace App\Controller;

use App\Entity\Boat;
use App\Repository\BoatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MapManagerService;

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

    #[Route('/direction/{direction}', name: 'directionBoat', requirements: ['direction' => '/|N|S|E|W|/i'])]
    public function direction(string $direction, BoatRepository $boatRepository, EntityManagerInterface $em, MapManagerService $mapManagerService): Response
    {
        $boat = $boatRepository->findOneBy([]);
        $boat->setDirection($direction);
        
        switch($direction){
            case "N" :
                if ($mapManagerService->tileExists($boat->getCoordX(), $boat->getCoordY() - 1))
                $boat->setCoordY($boat->getCoordY() - 1) ;
                break;
            case "S" :
                if ($mapManagerService->tileExists($boat->getCoordX(), $boat->getCoordY() + 1))
                $boat->setCoordY($boat->getCoordY() + 1) ;
                break;
            case "E" :
                if ($mapManagerService->tileExists($boat->getCoordX() + 1, $boat->getCoordY()))
                $boat->setCoordX($boat->getCoordX() + 1) ;
                break;
            case "W" :
                if ($mapManagerService->tileExists($boat->getCoordX() - 1, $boat->getCoordY()))
                $boat->setCoordX($boat->getCoordX() - 1) ;
                break;
            default ;
        }
        $em->flush();
        return $this->redirectToRoute('map');

    }
        

}
