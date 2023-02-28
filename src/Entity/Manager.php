<?php

namespace App\Entity;

use App\Repository\ManagerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ManagerRepository::class)]
class Manager extends User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'manager', targetEntity: tableau::class)]
    private Collection $tableau;

    public function __construct()
    {
        $this->tableau = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Tableau>
     */
    public function getTableau(): Collection
    {
        return $this->tableau;
    }

    public function addTableau(Tableau $tableau): self
    {
        if (!$this->tableau->contains($tableau)) {
            $this->tableau->add($tableau);
            $tableau->setUser($this);
        }

        return $this;
    }

    public function removeTableau(Tableau $tableau): self
    {
        if ($this->tableau->removeElement($tableau)) {
            // set the owning side to null (unless already changed)
            if ($tableau->getUser() === $this) {
                $tableau->setUser(null);
            }
        }

        return $this;
    }
}
