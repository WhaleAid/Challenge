<?php

namespace App\Entity;

use App\Repository\TacheRepository;
use App\Traits\TimeStampTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TacheRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Tache
{
    use TimeStampTrait;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    private ?Status $status = null;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    private ?Priorite $priorite = null;

    #[ORM\ManyToMany(targetEntity: Topic::class, mappedBy: 'tache')]
    private Collection $topics;

    #[ORM\ManyToOne(inversedBy: 'taches')]
    private ?Tableau $tableau = null;

    #[ORM\OneToMany(mappedBy: 'tache', targetEntity: Comment::class, orphanRemoval: true)]
    private Collection $comments;

    public function __construct()
    {
        $this->topics = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getStatus(): ?Status
    {
        return $this->status;
    }

    public function setStatus(?Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPriorite(): ?Priorite
    {
        return $this->priorite;
    }

    public function setPriorite(?Priorite $priorite): self
    {
        $this->priorite = $priorite;

        return $this;
    }

    /**
     * @return Collection<int, Topic>
     */
    public function getTopics(): Collection
    {
        return $this->topics;
    }

    public function addTopic(Topic $topic): self
    {
        if (!$this->topics->contains($topic)) {
            $this->topics->add($topic);
            $topic->addTache($this);
        }

        return $this;
    }

    public function removeTopic(Topic $topic): self
    {
        if ($this->topics->removeElement($topic)) {
            $topic->removeTache($this);
        }

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

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setTache($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTache() === $this) {
                $comment->setTache(null);
            }
        }

        return $this;
    }
}
