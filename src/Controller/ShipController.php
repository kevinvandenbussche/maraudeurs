<?php


namespace App\Controller;


use App\Controller\service\ApiService;
use App\Entity\Ship;
use App\Repository\ShipRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ShipController extends AbstractController
{
    /**
     * @Route ("/insert/ship", name="insert_ship")
     */

    public function insertShip(ApiService $apiService, EntityManagerInterface $entityManager, ShipRepository $shipRepository)
    {
        $shipsData = $shipRepository->findAll();
        $shipDataName = [ ];
        if(!empty($shipsData)){
            foreach ($shipsData as $shipData){
                $shipDataName[ ]  = $shipData->getName();
            }
        }
        $nameShip = [ ];
        $datas = $apiService->getDataShip();
        foreach ($datas as $data){
            if (is_array($data) || is_object($data)){
                foreach ($data as $value){
                    if($value != null){
                        $nameShip [ ] = $value['name'];
                    }
                }
            }
        }
        $computeArray = array_diff($nameShip, $shipDataName);
        if(!empty($computeArray)){
            foreach ($computeArray as $newShipInDataBase){
                $ship = new Ship();
                $ship->setName($newShipInDataBase);
                $entityManager->persist($ship);
                $entityManager->flush();
                $this->addFlash(
                    'success',
                    'le vaisseau' . $ship->getName() . 'a été crée');
            }
        }

        return $this->redirectToRoute('display_ship');
    }

    /**
     * @Route("/display/ship", name="display_ship")
     */

    public function displayShip(ShipRepository $shipRepository)
    {
        $allShip = $shipRepository->findAll();

        return $this->render('user/ship.html.twig',[
            'ships'=>$allShip
        ]);
    }

}
