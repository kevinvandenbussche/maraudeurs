<?php

namespace App\Entity;

use App\Repository\CategoryArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryArticleRepository::class)
 */
class CategoryArticle
{   //j'indique la relation que la table article et category article vont avoir entre elles
    //(ici plusieurs articles peuvent etre dans chaque categories)
    //j'indique a doctrine ou aller chercher la foreign key (ici dans la table article)
    /**
     * @ORM\OneToMany (targetEntity="App\Entity\Article", mappedBy="categoryArticle")
     */
    private $article;


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;


    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param mixed $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }

}
