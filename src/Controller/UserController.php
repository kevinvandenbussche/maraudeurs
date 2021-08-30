<?php


namespace App\Controller;


use App\Entity\Media;
use App\Form\UserUpdateFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
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

        return $this->render('admin/role.html.twig', [
            'users' => $users

        ]);
    }

    /**
    * @Route("admin/user/role/update", name = "roleUpdate")
     * @IsGranted("ROLE_ADMIN")
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
        $user->setRoles($role);
        $entityManager->persist($user);
        $entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur ' . $user->getPseudonyme() . ' était bien modifié!');
        return $this->redirectToRoute('role');
    }

    /**
     * @Route ("user/profile/update/{id}", name="user_update")
     */
    public function userUpdate(
        $id,
        UserRepository $userRepository,
        Request $request,
        EntityManagerInterface $entityManager
    )
    {
        $user = $userRepository->find($id);
        $form = $this->createForm(UserUpdateFormType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user = $form->getData();
            $media = $form->get('media')->getData();
            $newfiles = md5(uniqid()) . '.' . $media->guessExtension();
            try {
                //je deplace mon fichier
                $media->move(
                //je le mets dans le dossier files qui est dans public
                    $this->getParameter('media_directory'),
                    $newfiles
                );
                //si le code ne s'effectue pas je fais remonter une erreur a l'utilisateur
            } catch (FileException $e) {
                //si le fichier ne se deplace pas je fais remonter un message d'erreur
                throw new \Exception("une erreur c'est produite");
            }
            $entityManager->persist($user);

            $media = new Media();
            $media->setUrl($newfiles);
            $media->setName($user->getPseudonyme());
            $media->setUser($user);
            $user->setMedia($media);
            $entityManager->persist($media);
            $entityManager->flush();
            $this->redirectToRoute('home_page');
            // do anything else you need here, like send an email
        }
        return $this->render('management_user/user_update.html.twig', [
            'UserUpdateForm' => $form->createView(),

        ]);
    }


    /**
     * @Route("admin/user/delete/{id}", name = "delete_user")
     * @IsGranted ("ROLE_ADMIN")
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

//    /**
//     * @Route("/user/{id}", name="update_user")
//     */
//    public function updateUser($id, UserRepository $userRepository, EntityManagerInterface $entityManager)
//    {
//        $user = $userRepository->find($id);
//        $entityManager->persist($user);
//        $entityManager->flush();
//        $this->addFlash(
//            'success',
//            'Votre profil a été modifié'
//        );
//
//        return $this->redirectToRoute('home_page');
//
//    }
}
