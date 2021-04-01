<?php


namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    /**
     * @Route ("/articles", name="display_articles")
     */
    public function displayArticles(ArticleRepository $articleRepository)
    {
        $articles= $articleRepository->findAll();

        return $this->render('categories_articles.html.twig',
                ['articles'=>$articles]
        );
    }

    /**
     * @Route("insert/article", name="insert_article")
     */
    public function insertArticle(Request $request, EntityManagerInterface $entityManager)
    {
        //je creer un nouvelle entité que je mets dans une variable
        $article = new Article();
        //j'utilise une methode d'AbstractController qui me permet de créer un formulaire avec les champs de mon
        //entité Article que je mets dans un variable
        $form = $this->createForm(ArticleType::class, $article);
        //une methode qui me permet de gerer les données du formulaire en POST
        $form->handleRequest($request);
        //je verifie que les champs de mon formulaire sont bien remplie et valide
        if ($form->isSubmitted() && $form->isValid()) {
            //revoi l'objet CategoryArticle avec les données du formulaire
            $article = $form->getData();
            //je recupere la date du jour avec  le set date de mon entite
            $article->setDate( new \DateTime());
            // je recupere l'id du user qui publie l'article
            $article->getUser();
            //je mets mes données dans une boite en attente d'envoi en base de donnée
            $entityManager->persist($article);
            //j'envoi mon objet en base de donnée
            $entityManager->flush();
            //j'affiche un message flash
            $this->addFlash(
                'success',
                'l\' article a été creé'
            );
            //je renvoi l'utilisateur sur la page de formulaire de création
            return $this->redirectToRoute('insert_article');
        }
        //j'envoi l'utilisateur sur une page avec le formulaire de creation
        return $this->render('insert_update_article.html.twig', [
            'articles' => $form->createView()
        ]);
    }

    /**
     * @Route ("/update/article", name="update_article")
     */

        //j'utilise l'autowire pour instanicer ma méthode
        public function updateCategory($id, ArticleRepository $articleRepository, Request $request, EntityManagerInterface $entityManager)
        {
        //j'utilise doctrine pour faire une requete select avec en paramatre l'id qui est dans l'url que je mets dans un variable
        $article= $articleRepository->find($id);

        $form= $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $entityManager->persist($article);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'l\'article a été modifiée'
            );

        }
        return $this->render('insert_update_articles.html.twig', [
            'articles' => $form->createView()
        ]);

    }


}