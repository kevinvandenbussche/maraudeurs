<?php


namespace App\Controller;



use App\Repository\CategoryArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route ("/categories/articles", name="index_category")
     */
    public function displayCategory(CategoryArticleRepository $categoryArticleRepository)
    {

        $categories = $categoryArticleRepository->findAll();

        return $this->render('category.articles.html.twig',
            ['categories'=>$categories]
        );

    }

}