<?php

namespace App\Controller;

use App\Entity\Boat;
use App\Repository\BoatRepository;
use App\Repository\TileRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Exception;

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

    #[Route('/direction/{direction}', name: 'moveDirection', requirements: ['direction' => '/|n|s|e|w|/i'])]
    public function moveDirection(string $direction, BoatRepository $boatRepository, TileRepository $tileRepository, EntityManagerInterface $em): Response
    {
        $boat = $boatRepository->findOneBy([]);
        $tile = $tileRepository->findOneBy([]);

        $getX = $boat->getCoordX();
        $getY = $boat->getCoordY();
        $type = $tile->getType();



        switch ($direction) {
            case 'n':
                if ($getY <= 0) {
                    throw new Exception('Out of Map');
                }
                $boat->setCoordY($boat->getCoordY() - 1);
                echo "you head N";
                break;
            case 's':
                if ($getY >= 5) {
                    throw new Exception('Out of Map');
                }
                $boat->setCoordY($boat->getCoordY() + 1);
                echo "you head S";
                break;
            case 'w':
                if ($getX <= 0) {
                    throw new Exception('Out of Map');
                }
                $boat->setCoordX($boat->getCoordX() - 1);
                echo "you head W";
                break;
            case 'e':
                if ($getX >= 11) {
                    throw new Exception('Out of Map');
                }
                $boat->setCoordX($boat->getCoordX() + 1);
                echo "you head E";
                break;
            default:
                echo "not valid direction";
                break;
        }
        $em->flush();

        return $this->redirectToRoute('map');
    }
}
