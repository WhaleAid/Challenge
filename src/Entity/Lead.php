<?php

namespace App\Entity;

use App\Repository\LeadRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeadRepository::class)]
class Lead extends User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'lead', cascade: ['persist', 'remove'])]
    private ?Equipe $equipe = null;

    #[ORM\OneToOne(inversedBy: 'lead', cascade: ['persist', 'remove'])]
    private ?Tableau $tableau = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): self
    {
        $this->equipe = $equipe;

        return $this;
    }

    public function getTableau(): ?Tableau
    {
        return $this->tableau;
    }

    public function setTableau(?Tableau $tableau): self
    {
        $this->tableau = $tableau;

        return $this;
    }
}
