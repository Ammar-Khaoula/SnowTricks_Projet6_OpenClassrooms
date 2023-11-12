<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TricksRepository;
use EsperoSoft\DateFormat\DateFormat;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TricksRepository::class)]
#[UniqueEntity(fields: ['name'], message: 'Il existe déjà un Tricks avec cette nom')]
class Tricks
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $discription = null;


    #[ORM\ManyToOne(inversedBy: 'tricks')]
    private ?Category $categories = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'trick', targetEntity: Comments::class, orphanRemoval: true)]
    private Collection $comments;

    private ?string $fromNow = null;

    #[ORM\OneToMany(mappedBy: 'tricks', targetEntity: ImageUrls::class, orphanRemoval: true, cascade:['persist'] )]
    private Collection $imageUrls;

    #[ORM\OneToMany(mappedBy: 'tricks', targetEntity: VideoUrls::class, orphanRemoval: true, cascade:['persist'] )]
    #[Assert\Count(min:1)]
    private Collection $videoUrls;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?PictureTrick $pictureTrick = null;



    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->setCreatedAt(new \DateTimeImmutable());
        $this->imageUrls = new ArrayCollection();
        $this->videoUrls = new ArrayCollection();

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;
        $this->setSlug((new Slugify())->slugify($this->name));

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }

    public function getDiscription(): ?string
    {
        return $this->discription;
    }

    public function setDiscription(string $discription): static
    {
        $this->discription = $discription;

        return $this;
    }

    public function getCategories(): ?Category
    {
        return $this->categories;
    }

    public function setCategories(?Category $categories): static
    {
        $this->categories = $categories;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * @return Collection<int, Comments>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comments $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setTrick($this);
        }

        return $this;
    }

    public function removeComment(Comments $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }

        return $this;
    }
    /**
     * Get the value of fromNow
     * 
     * @return string
     */
    public function getfromNow(): ?string
    {
        return DateFormat::fromNow($this->createdAt);
    }

    /**
     * @return Collection<int, ImageUrls>
     */
    public function getImageUrls(): Collection
    {
        return $this->imageUrls;
    }

    public function addImageUrl(ImageUrls $imageUrl): static
    {
        if (!$this->imageUrls->contains($imageUrl)) {
            $this->imageUrls->add($imageUrl);
            $imageUrl->setTricks($this);
        }

        return $this;
    }

    public function removeImageUrl(ImageUrls $imageUrl): static
    {
        if ($this->imageUrls->removeElement($imageUrl)) {
            // set the owning side to null (unless already changed)
            if ($imageUrl->getTricks() === $this) {
                $imageUrl->setTricks(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, VideoUrls>
     */
    public function getVideoUrls(): Collection
    {
        return $this->videoUrls;
    }

    public function addVideoUrl(VideoUrls $videoUrl): static
    {
        if (!$this->videoUrls->contains($videoUrl)) {
            $this->videoUrls->add($videoUrl);
            $videoUrl->setTricks($this);
        }

        return $this;
    }

    public function removeVideoUrl(VideoUrls $videoUrl): static
    {
        if ($this->videoUrls->removeElement($videoUrl)) {
            // set the owning side to null (unless already changed)
            if ($videoUrl->getTricks() === $this) {
                $videoUrl->setTricks(null);
            }
        }

        return $this;
    }

 public function __toString(): string
             {
                 return $this->slug;
             }

    public function getPictureTrick(): ?PictureTrick
    {
        return $this->pictureTrick;
    }

    public function setPictureTrick(?PictureTrick $pictureTrick): static
    {
        $this->pictureTrick = $pictureTrick;

        return $this;
    }
}
