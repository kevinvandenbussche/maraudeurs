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
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="media")
     */
    private $user;

    //j'indique à doctrine que plusieurs Media peuvent être dans Article
    /**
     * @ORM\ManyToMany (targetEntity="App\Entity\Article", inversedBy="media")
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


    public function __construct()
    {
        $this->article= new ArrayCollection();

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
    public function setUser($user)
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
     * @param Article $article
     * @return Media
     */

    public function addArticle(Article $article): self
    {
        if (!$this->article->contains($article)) {
            $this->article[] = $article;
            $article->addMedia($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->article->removeElement($article)) {
            $article->removeMedia($this);
        }

        return $this;
    }


}