<?php

namespace App\Controller;

use App\Entity\Boat;
use App\Repository\BoatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\MapManager;
use PhpParser\Node\Expr\AssignOp\Mod;


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
    public function moveDirection(string $direction, BoatRepository $boatRepository, EntityManagerInterface $em, MapManager $mapManager): Response
    {
      $boat = $boatRepository->findOneBy([]);
      $y = $boat->getCoordY();
      $x = $boat->getCoordX();

      switch($direction){
        case "N" :
            $y--;
            break;
        case "S" :
            $y++;
            break;
        case "E" :
            $x++;
            break;
        case "W" :
            $x--;
            break;
        default ;
    }

    if ($mapManager->tileExists($x, $y) === true) {
      $boat->setCoordX($x);
      $boat->setCoordY($y);
      $em->flush();
      return $this->redirectToRoute('map');

    }else {
      $this->addFlash('alert', "That's the end of the world mate");
      return $this->redirectToRoute('map');
    }
    }
}
