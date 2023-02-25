<?php

namespace App\Entity;

use App\Repository\DevRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DevRepository::class)]
class Dev extends User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'devs')]
    private ?Equipe $equipe = null;

    #[ORM\ManyToOne(inversedBy: 'devs')]
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
