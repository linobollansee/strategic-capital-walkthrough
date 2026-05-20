<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'portfolio')]
class Portfolio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private string $name;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(name: 'created_at', type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    #[ORM\OneToMany(mappedBy: 'portfolio', targetEntity: InvestmentSnapshot::class, cascade: ['persist', 'remove'])]
    private Collection $snapshots;

    #[ORM\OneToMany(mappedBy: 'portfolio', targetEntity: Allocation::class, cascade: ['persist', 'remove'])]
    private Collection $allocations;

    public function __construct(string $name, \DateTimeImmutable $createdAt)
    {
        $this->name = $name;
        $this->createdAt = $createdAt;
        $this->snapshots = new ArrayCollection();
        $this->allocations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
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

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getSnapshots(): Collection
    {
        return $this->snapshots;
    }

    public function addSnapshot(InvestmentSnapshot $snapshot): self
    {
        if (!$this->snapshots->contains($snapshot)) {
            $this->snapshots->add($snapshot);
            $snapshot->setPortfolio($this);
        }
        return $this;
    }

    public function removeSnapshot(InvestmentSnapshot $snapshot): self
    {
        if ($this->snapshots->removeElement($snapshot)) {
            if ($snapshot->getPortfolio() === $this) {
                $snapshot->setPortfolio(null);
            }
        }
        return $this;
    }

    public function getAllocations(): Collection
    {
        return $this->allocations;
    }

    public function addAllocation(Allocation $allocation): self
    {
        if (!$this->allocations->contains($allocation)) {
            $this->allocations->add($allocation);
            $allocation->setPortfolio($this);
        }
        return $this;
    }

    public function removeAllocation(Allocation $allocation): self
    {
        if ($this->allocations->removeElement($allocation)) {
            if ($allocation->getPortfolio() === $this) {
                $allocation->setPortfolio(null);
            }
        }
        return $this;
    }
}
