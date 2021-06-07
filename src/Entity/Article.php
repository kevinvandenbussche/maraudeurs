<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ArticleRepository::class)
 */
class Article
{

    //je dis a doctrine quelle est la table a relié avec article et le ManyToOne indique les cardinalités
    //plusieurs Article peuvent etre dans Category
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\CategoryArticle", inversedBy="article")
     */
    private $categoryArticle;

    /**
     * @ORM\ManyToOne (targetEntity="App\Entity\User", inversedBy="article")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $articleContent;

    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Assert\NotBlank(
     *     message="Ce champs ne peut pas être vide"
     * )
     * @Assert\Length(
     *     min=5,
     *     minMessage="Votre titre est trop court",
     *     max=50,
     *     maxMessage="Votre titre est un peu trop long, essayez de le simplifier"
     * )
     */
    private $title;
    //j'indique à Doctrine que plusieurs Article peuvent être dans Media, cascade me permet d'affecter les données des entités enfant
    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Media", mappedBy="article", cascade="persist")
     */
    private $media;
    //je crée un Array collection pour pouvoir stocker chaque donné
    public function __construct()
    {
        $this->media = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArticleContent(): ?string
    {
        return $this->articleContent;
    }

    public function setArticleContent(?string $articleContent): self
    {
        $this->articleContent = $articleContent;

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
    public function getCategoryArticle()
    {
        return $this->categoryArticle;
    }

    /**
     * @param mixed $categoryArticle
     */
    public function setCategoryArticle($categoryArticle): void
    {
        $this->categoryArticle = $categoryArticle;
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
     * @return Collection|media[]
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedia(media $media): self
    {
        if (!$this->media->contains($media)) {
            $this->media[] = $media;
        }

        return $this;
    }

    public function removeMedia(media $media): self
    {
        $this->media->removeElement($media);

        return $this;
    }


}