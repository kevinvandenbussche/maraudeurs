<?php

namespace App\Controller;

use App\Entity\Media;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\UserAuthentificator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     * @throws \Doctrine\ORM\ORMException
     */
    public function register(Request $request, EntityManagerInterface $entityManager, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UserAuthentificator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $user= $form->getData();


        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()

                )
            );
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

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),

        ]);

    }
}
