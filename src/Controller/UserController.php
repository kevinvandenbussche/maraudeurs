<?php


namespace App\Controller;


use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use http\Client\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("admin/user", name="role")
     * @IsGranted ("ROLE_ADMIN")
     */
    public function roleUser(UserRepository $repository)
    {
        $users = $repository->findAll();

        return $this->render('admin/role.html.twig', [
            'users' => $users

        ]);
    }

    /**
    * @Route("admin/user/update", name = "roleUpdate")
     * @IsGranted ("ROLE_ADMIN")
    */
    public function roleUpdate(UserRepository $repository, Request $request, EntityManagerInterface $entityManager)
    {
        //ici je decide des rôles de mes differents utilisateurs qui sont stocké dans des tableaux
        $user = $repository->findOneBy(['id' => $request->request->get('id')]);
        $role = array('ROLE_WAITING');
        if ($request->request->get('role') === "waiting") {
            $role = array('ROLE_WAITING');
        } elseif ($request->request->get('role') === "user") {
            $role = array('ROLE_USER');
        } elseif ($request->request->get('role') === "admin") {
            $role = array('ROLE_ADMIN');}

        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur ' . $user->getPseudonyme() . ' était bien modifié!');
        return $this->redirectToRoute('role');
    }

    /**
     * @Route("admin/user/delete/{id}", name = "delete_user")
     * * @IsGranted ("ROLE_ADMIN")
     */
    public function deleteUser(UserRepository $repository,EntityManagerInterface $entityManager, $id)
    {
        $user = $repository->find($id);
        $entityManager->remove($user);
        $entityManager->flush();
        $this->addFlash(
            'success',
            'l\'utilisateur a été bien supprimé '
        );
        //je renvoi l'utilisateur vers la page des categories
        return $this->redirectToRoute('role');
    }
}