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
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="category_article")
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
    //dans le oneToMany je creer un array collection qui evitera d'ecraser les données de la table de article
    public function __construct()
    {
        $this->article = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
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
    public function setArticle($article): void
    {
        $this->article = $article;
    }

}
