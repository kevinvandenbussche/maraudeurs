<?php


namespace App\Controller;


use App\Controller\service\ApiService;
use App\Entity\Ship;
use App\Repository\ShipRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;


class ShipController extends AbstractController
{

    /**
     * @Route ("/insert/ship", name="insert_ship")
     */

    public function insertShip(ApiService $apiService, EntityManagerInterface $entityManager, ShipRepository $shipRepository)
    {

        $shipsData = $shipRepository->findAll();
        $shipDataName = [];
        if (!empty($shipsData)) {
            foreach ($shipsData as $shipData) {
                $shipDataName[] = $shipData->getName();
            }
        }
        $nameShip = [];
        $datas = $apiService->getDataShip();
        foreach ($datas as $data) {
            if (is_array($data) || is_object($data)) {
                foreach ($data as $value) {
                    if ($value != null) {
                        $nameShip [] = $value['name'];
                    }
                }
            }
        }
        $arrayClean = [ ];

        foreach ($nameShip as $test => $value){
            if(stristr($value, 'Edition') == false && $value != 'Carrack')
            {
                $arrayClean[] = $value;
            }
        }

        $computeArray = array_diff($arrayClean, $shipDataName);
        if (!empty($computeArray)) {
            foreach ($computeArray as $newShipInDataBase) {
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

        return $this->render('user/ship.html.twig', [
            'ships' => $allShip
        ]);
    }

    /**
     * @Route("/insert/ship/user", name="insert_ship_user")
     */
    public function insertShipUser(ShipRepository $shipRepository)
    {
        $ships = $shipRepository->findAll();
        return $this->render('user/insert_ship_user.html.twig', [
            'ships' => $ships
        ]);


    }

    /**
     * @Route("insert/ship/user/{id}", name="insert_ship_by_user")
     */

    public function insertShipByUser(ShipRepository $shipRepository,
                                     $id,
                                     EntityManagerInterface $entityManager)
    {
        $user = $this->getUser();
        $ship = $shipRepository->find($id);

        $user->addShip($ship);

        $entityManager->persist($user);
        $entityManager->flush();

        return $this->json([
            'ship'=>$ship
            ],200, [], ['groups'=>['user']
        ]);
    }

    /**
     * @Route("number/ship", name="number_ship")
     */

    public function numberShip(UserRepository $userRepository, ShipRepository $shipRepository)
    {
        $ships = $shipRepository->findAll();

        foreach ($ships as $ship){
            $ship->getName();
        }
        $users = $userRepository->findAll();
        $nameShips = [ ];

        foreach ($users as $user){
            $ships = $user->getShips();
            foreach ($ships as $ship){
                $nameShips[ ] = $ship->getName();
            }
        }

        return $this->render('user/number_ship.html.twig');

    }

}







