<?php

namespace App\Entity;

use App\Repository\EditoImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EditoImageRepository::class)]
class EditoImage
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $fichier = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $legende = null;

    #[ORM\ManyToOne(inversedBy: 'images')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Edito $edito = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFichier(): ?string
    {
        return $this->fichier;
    }

    public function setFichier(string $fichier): self
    {
        $this->fichier = $fichier;
        return $this;
    }

    public function getLegende(): ?string
    {
        return $this->legende;
    }

    public function setLegende(?string $legende): self
    {
        $this->legende = $legende;
        return $this;
    }

    public function getEdito(): ?Edito
    {
        return $this->edito;
    }

    public function setEdito(?Edito $edito): self
    {
        $this->edito = $edito;
        return $this;
    }
}
