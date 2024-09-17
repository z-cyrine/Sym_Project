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
    #[ORM\OneToMany(targetEntity: Watch::class, mappedBy: 'watchBox')]
    private Collection $watches;

    public function __construct()
    {
        $this->watches = new ArrayCollection();
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
}
