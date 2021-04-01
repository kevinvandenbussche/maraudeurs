<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LorePageController extends AbstractController
{
    /**
     * @Route ("/lore", name="lore_page")
     */
    public function lorePage()
    {
        return $this->render('lore.html.twig');
    }
}