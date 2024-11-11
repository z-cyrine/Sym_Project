<?php

namespace App\Entity;

use App\Repository\WatchBoxRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WatchBoxRepository::class)]
class WatchBox
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Watch>
     */
    #[ORM\OneToMany(targetEntity: Watch::class, mappedBy: 'watchBox', fetch:'EAGER')]
    private Collection $watches;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\OneToOne(mappedBy: 'watchBox', cascade: ['persist', 'remove'])]
    private ?Member $member = null;

    public function __construct()
    {
        $this->watches = new ArrayCollection();
    }
    
    public function __toString(): string
    {
        return $this->name;
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Watch>
     */
    public function getWatches(): Collection
    {
        return $this->watches;
    }

    public function addWatch(Watch $watch): static
    {
        if (!$this->watches->contains($watch)) {
            $this->watches->add($watch);
            $watch->setWatchBox($this);
        }

        return $this;
    }

    public function removeWatch(Watch $watch): static
    {
        if ($this->watches->removeElement($watch)) {
            // set the owning side to null (unless already changed)
            if ($watch->getWatchBox() === $this) {
                $watch->setWatchBox(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getMember(): ?Member
    {
        return $this->member;
    }

    public function setMember(?Member $member): static
    {
        // unset the owning side of the relation if necessary
        if ($member === null && $this->member !== null) {
            $this->member->setWatchBox(null);
        }

        // set the owning side of the relation if necessary
        if ($member !== null && $member->getWatchBox() !== $this) {
            $member->setWatchBox($this);
        }

        $this->member = $member;

        return $this;
    }
    
}
