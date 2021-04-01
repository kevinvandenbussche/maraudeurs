<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{

    //je dis a doctrine quelle est la table a relié avec article et le ManyToOne indique les cardinalités
    //plusieurs article peuvent etre dans category
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategoryArticle", inversedBy="article")
     */
    private $category;

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\User", inversedBy="article")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    //j'indique a doctrine que les articles peuvent avoir plusieurs media
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Media", inversedBy="article")
     */
    private $media;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $text;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $article;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    public function __construct()
    {
        $this->media = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }

    public function getArticle(): ?string
    {
        return $this->article;
    }

    public function setArticle(?string $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category): void
    {
        $this->category = $category;
    }

    /**
     * @return ArrayCollection
     */
    public function getMedia(): ArrayCollection
    {
        return $this->media;
    }

    /**
     * @param ArrayCollection $media
     */
    public function setMedia(ArrayCollection $media): void
    {
        $this->media = $media;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }


}
