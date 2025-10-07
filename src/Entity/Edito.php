<?php

namespace App\Entity;

use App\Repository\EditoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EditoRepository::class)]
class Edito
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $titre = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $contenu = null;

    // Image de couverture principale
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photoPrincipale = null;

    #[ORM\OneToMany(mappedBy: 'edito', targetEntity: EditoImage::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $images;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $datePublication = null;
    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;
        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;
        return $this;
    }

    public function getPhotoPrincipale(): ?string
    {
        return $this->photoPrincipale;
    }

    public function setPhotoPrincipale(?string $photoPrincipale): self
    {
        $this->photoPrincipale = $photoPrincipale;
        return $this;
    }

    /**
     * @return Collection<int, EditoImage>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(EditoImage $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setEdito($this);
        }

        return $this;
    }

    public function removeImage(EditoImage $image): self
    {
        if ($this->images->removeElement($image)) {
            if ($image->getEdito() === $this) {
                $image->setEdito(null);
            }
        }

        return $this;
    }
    public function getDatePublication(): ?\DateTimeInterface
    {
        return $this->datePublication;
    }

    public function setDatePublication(\DateTimeInterface $datePublication): static
    {
        $this->datePublication = $datePublication;

        return $this;
    }
}
