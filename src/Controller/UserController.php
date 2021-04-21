<?php


namespace App\Controller;


use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("admin/user", name="role")
     */
    public function roleUser(UserRepository $repository)
    {
        $users = $repository->findAll();
    dd($users);

        return $this->render('admin/role.html.twig', [
            'users' => $users

        ]);
    }

    /**
    * @Route("admin/user/update", name = "roleUpdate")
    */
    public function roleUpdate(UserRepository $repository, Request $request, EntityManagerInterface $entityManager)
    {
        $user = $repository->findOneBy(['id' => $request->request->get('id')]);

        if ($request->request->get('role') === "admin") {
            $role = array('ROLE_ADMIN');
        } elseif ($request->request->get('role') === "user") {
            $role = array('ROLE_USER');
        } elseif ($request->request->get('role') === "officer") {
            $role = array('ROLE_OFFICER');
        }

        $user->setRoles($role);
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'Le User ' . $user->getEmail() . ' était bien modifié!');
        return $this->redirectToRoute('role');
    }
}