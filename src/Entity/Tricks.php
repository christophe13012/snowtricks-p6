<?php

namespace App\Entity;

use App\Repository\TricksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TricksRepository::class)
 */
class Tricks
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique = true)
     * @Assert\NotBlank(message="Le nom ne doit pas être vide")
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "Name must be at least {{ limit }} characters long",
     *      maxMessage = "Name cannot be longer than {{ limit }} characters"
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="La description ne doit pas être vide")
     */
    private $description;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Merci de choisir une photo")
     */
    private $mainImage;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class)
     * @Assert\NotBlank
     */
    private $category;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="trick", cascade={"persist", "remove"})
     */
    private $photos;

    /**
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="trick", cascade={"persist", "remove"})
     */
    private $videos;

    /** @ORM\Column(type="string") **/
    private $url_path;

    public function __construct()
    {
        $this->photos = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMainImage(): ?string
    {
        return $this->mainImage;
    }

    public function setMainImage(string $mainImage): self
    {
        $this->mainImage = $mainImage;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setTrick($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getTrick() === $this) {
                $photo->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->photos->contains($video)) {
            $this->videos[] = $video;
            $video->setTrick($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->photos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getTrick() === $this) {
                $video->setTrick(null);
            }
        }

        return $this;
    }

    public function getUrlPath()
    {
        return $this->url_path;
    }

    public function setUrlPath($titre)
    {
        if (is_string($titre)) {
            $accents = array("/é/", "/è/", "/ê/", "/ë/", "/ç/", "/à/", "/â/", "/á/", "/ä/", "/ã/", "/å/", "/î/", "/ï/", "/í/", "/ì/", "/ù/", "/ô/", "/ò/", "/ó/", "/ö/");
            $sans = array("e", "e", "e", "e", "c", "a", "a", "a", "a", "a", "a", "i", "i", "i", "i", "u", "o", "o", "o", "o");
            $url_path = preg_replace($accents, $sans, $titre);
            $url_path = str_replace(' ', '-', $url_path);
            $url_path = preg_replace('/[^A-Za-z0-9\-]/', '', $url_path);
            $url_path = preg_replace('/-+/', '-', $url_path);
            $this->url_path = $url_path;
        }
    }
}
