<?php

namespace App\Entity;

use App\Repository\MediaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MediaRepository::class)
 */
class Media
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="media")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    //j'indique a doctrine que plusieurs media peuvent etre dans articles
    /**
     * @ORM\ManyToMany (targetEntity="App\Entity\Article", mappedBy="media")
     */
    private $article;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Article::class, mappedBy="mediaArticle")
     */
    private $articles;

    public function __construct()
    {
        $this->article= new ArrayCollection();
        $this->articles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
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

    /**
     * @return ArrayCollection
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param ArrayCollection $article
     */
    public function setArticle(ArrayCollection $article): void
    {
        $this->article = $article;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->addMediaArticle($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            $article->removeMediaArticle($this);
        }

        return $this;
    }

}
