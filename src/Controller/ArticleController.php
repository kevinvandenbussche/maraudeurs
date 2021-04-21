<?php


namespace App\Controller;

use App\Entity\Article;
use App\Entity\Media;
use App\Form\ArticleType;
use App\Form\MediaType;
use App\Repository\ArticleRepository;
use App\Repository\CategoryArticleRepository;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ArticleController extends AbstractController
{
    /**
     * @Route ("/articles/{id}", name="display_articles")
     */
    public function displayArticles(ArticleRepository $articleRepository, $id, CategoryArticleRepository $categoryArticleRepository)
    {
        //je fais une requête de type select avec doctrine dans ma table article qui me de recuperer les articles et je les tries avec
        //l'id que jai dans mon URL qui correspond au champ de categorie_id dans ma BDD
        $articles = $articleRepository->findBy(['category' => $id]);
        //je fais une requete de type select dans ma table category que je trie avec l'id qui est dans mon url
        $category = $categoryArticleRepository->find($id);
        return $this->render('articles.html.twig', [
            //je mets le retour de mes requetes dans des variables twig
            'articles'=>$articles,
            'category'=>$category
        ]);
    }

    /**
     * @Route("insert/article", name="insert_article")
     */
    public function insertArticle(Request $request,
                                  EntityManagerInterface $entityManager)
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
//            dump($request->request->get('test'));
//            dd($form);
            //revoi l'objet Article avec les données du formulaire
            $article = $form->getData();
            //je recupere la date du jour avec le set date de mon entite
            $article->setDate( new \DateTime());
            // je recupere l'id du user qui publie l'article
            $article->getUser();
            //je recupere mon tableau de media que je mets dans une variable
            $medias = $form->get('media')->getData();

            if($medias){
                //je boucle dessus
                foreach ($medias as $media){
                    //je modifie le nom de mon fichier pour pouvoir le stocker en bdd
                    $newfiles = md5(uniqid()).'.'.$media->guessExtension();

                    try {
                        //je deplace mon fichier
                        $media->move(
                            //je le mets dans le dossier files qui est dans public
                            $this->getParameter('media_directory'),
                            $newfiles

                        );
                    //si le code ne s'effectue pas je fais remonter une erreur a l'utilisateur
                    }catch (FileException $e){
                        //si le fichier ne deplace je fais remonter un message d'erreur
                        throw new \Exception("le fichier n\'a pas été enregistré");
                    }
                    $media = new Media();
                    $media->setUrl($newfiles)
                            ->setName($form->get('title')->getData());

                    $entityManager->persist($media);
                }
            }
            //je mets l'entité manager pour pre-sauvegarder mon entité Article
            $entityManager->persist($article);
            $entityManager->flush();
            //j'affiche un message flash
            $this->addFlash(
                'success',
                'l\' article a été creé'
            );
            //je renvoi l'utilisateur sur le formulaire de modfication et j'indique l'id pour pouvoir indiquer a symfony
            //quelle article il doit afficher
            return $this->redirectToRoute('show_article', ['id'=>$article->getId()]);
        }

        //j'envoi l'utilisateur sur une page avec le formulaire de creation
        return $this->render('insert_update_article.html.twig', [
            'articles' => $form->createView()
        ]);
    }

    /**
     * @Route ("/update/article/{id}", name="update_article")
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
        return $this->render('insert_update_article.html.twig', [
            'articles' => $form->createView()
        ]);

    }

    /**
     * @Route("/show/article/{id}", name="show_article")
     */

    public function showArticle($id,ArticleRepository $articleRepository)
    {
        //je recupere un article et l'ID  me permet de savoir quelle article precisement je dois recuperer
        $article=$articleRepository->find($id);

        return $this->render('show_article.html.twig', [
            'article' => $article
        ]);
    }
    /**
     * @Route ("/delete/article/{id}", name="delete_article")
     */
    public function deleteArticle($id, ArticleRepository $articleRepository, EntityManagerInterface $entityManager)
    {

        $article= $articleRepository->find($id);
        //j'utilise la methode remove de doctrine qui me permet de faire la requete qui supprime la donnée
        $entityManager->remove($article);
        //j'envoie ne base de donnée
        $entityManager->flush();
        $this->addFlash(
            'success',
            'l\'article a été supprimé'
        );
        //je renvoi l'utilisateur vers la page des categories
        return $this->redirectToRoute('display_categories');

    }

}