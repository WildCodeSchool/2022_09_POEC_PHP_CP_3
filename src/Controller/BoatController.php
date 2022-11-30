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

    public const DIRECTIONS = [
        'N' => [0, -1],
        'E' => [1, 0],
        'S' => [0, 1],
        'W' => [-1, 0],
    ];


    /*#[Route('/move/{x}/{y}', name: 'moveBoat', requirements: ['x' => '\d+', 'y' => '\d+'])]
    public function moveBoat(int $x, int $y, BoatRepository $boatRepository, EntityManagerInterface $em): Response
    {
        $boat = $boatRepository->findOneBy([]);
        $boat->setCoordX($x);
        $boat->setCoordY($y);
        $em->flush();
        return $this->redirectToRoute('map');
    }*/

    #[Route('/move/{direction}', name: 'moveBoatDirection', requirements: ['direction' => '/|N|S|E|W|/i'])]
    public function moveDirection(string $direction, BoatRepository $boatRepository, EntityManagerInterface $em): Response
    {
        $boat = $boatRepository->findOneBy([]);
        $x = $boat->getCoordX();
        $y = $boat->getCoordY();

        if (!key_exists($direction, self::DIRECTIONS)) {
            throw new exception('Unknown direction');
        }

        $x = $x + self::DIRECTIONS[$direction][0];
        $y = $y + self::DIRECTIONS[$direction][1];

        $boat->setCoordX($x);
        $boat->setCoordY($y);
        $em->persist($boat);
        $em->flush();
        return $this->redirectToRoute('map');
    }
}