<?php


namespace App\Controller;


use App\Entity\CategoryArticle;
use App\Form\CategoryType;
use App\Repository\CategoryArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route ("/user")
 *
 */
//je creer une class a laquelle je fais heriter la class de symfony AbstractController
class CategoriesArticlesController extends AbstractController
{   //je creer une route qui me permet d'utiliser ma methode et je lui donne un nom
    /**
     * @Route ("/categories", name="display_categories")
     */
    //j'utilise l'auto wire qui me permet d'utiliser le repository creer par doctrine qui contient toutes les requetes
    public function displayCategories(CategoryArticleRepository $categoryArticleRepository)
    {
        //je recupere toutes les données avec findAll (requete de type select) que je mets dans une variable
        $categories = $categoryArticleRepository->findAll();
        //je renvoie le tout a ma vue avec la methode render qui est hériter d'AbstractController
        return $this->render('user/categories_articles.html.twig',
                // je mets ma variable $categories dans une variable twig. les données recuperer sont mises
                // dans un tableau
                ['categories'=>$categories]
        );
    }
    //je creer une route pour ma méthode et je lui donne un nom
    /**
     * @Route ("/insert/category", name="insert_category")
     */
    //j'instancie ma méthode avec des services de symfony
    public function insertCategory(Request $request, EntityManagerInterface $entityManager)
    {
        $title = 'Création';

        //je creer un nouvelle entité que je mets dans une variable
        $category = new CategoryArticle();
        //j'utilise une methode d'AbstractController qui me permet de créer un formulaire avec les champs de mon
        //entité CategoryArticle que je mets dans un variable
        $form = $this->createForm(CategoryType::class, $category);
        //une methode qui me permet de gerer les données du formulaire en POST
        $form->handleRequest($request);
        //je verifie que les champs de mon formulaire sont vien rempie et valide
        if ($form->isSubmitted() && $form->isValid()) {
            //revoi l'objet CategoryArticle avec les données du formulaire
            $category = $form->getData();
            //je mets mes données dans une boite en attente d'envoi en base de donnée
            $entityManager->persist($category);
            //j'envoi mon objet en base de donnée
            $entityManager->flush();
            //j'affiche un message flash
            $this->addFlash(
                'success',
                'la categorie a été creé'
            );
            //je renvoi l'utilisateur sur la page de formulaire de création
            return $this->redirectToRoute('insert_category');
        }
        //j'envoi l'utilisateur sur une page avec le formulaire de creation
        return $this->render('user/insert_update_category_articles.html.twig', [
            'categories' => $form->createView(),
            'title' => $title
            ]);
    }
    // je creer une route avec en parametre une wild card qui equivaut a l'id de la category souhaitez
    /**
     * @Route ("/update/category/{id}", name="update_category")
     */
    //j'utilise l'autowire pour instanicer ma méthode
    public function updateCategory($id, CategoryArticleRepository $categoryArticleRepository, Request $request, EntityManagerInterface $entityManager)
    {
        //j'utilise doctrine pour faire une requete select avec en paramatre l'id qui est dans l'url que je mets dans un variable
        $category= $categoryArticleRepository->find($id);

        $title = 'Modification';

        $form= $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'la categorie a été modifiée'
            );

        }
        return $this->render('user/insert_update_category_articles.html.twig', [
            'categories' => $form->createView(),
            'title' => $title
        ]);
    }
    //je creer une route avec une wild card
    /**
     * @Route ("/delete/category/{id}", name="delete_category")
     */
    public function deleteCategory($id, CategoryArticleRepository $categoryArticleRepository, EntityManagerInterface $entityManager)
    {

        $category= $categoryArticleRepository->find($id);
        //j'utilise la methode remove de doctrine qui me permet de faire la requete qui supprime la donnée
        $entityManager->remove($category);
        //j'envoie ne base de donnée
        $entityManager->flush();
        $this->addFlash(
            'success',
            'la categorie a été supprimé'
        );
        //je renvoi l'utilisateur vers la page des categories
        return $this->redirectToRoute('user/display_categories');

    }


}