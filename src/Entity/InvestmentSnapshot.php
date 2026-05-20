<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'investment_snapshot')]
class InvestmentSnapshot
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'snapshots')]
    #[ORM\JoinColumn(nullable: false)]
    private Portfolio $portfolio;

    #[ORM\Column(name: 'reviewed_at', type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $reviewedAt;

    public function __construct(Portfolio $portfolio, \DateTimeImmutable $reviewedAt)
    {
        $this->portfolio = $portfolio;
        $this->reviewedAt = $reviewedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPortfolio(): Portfolio
    {
        return $this->portfolio;
    }

    public function setPortfolio(?Portfolio $portfolio): self
    {
        $this->portfolio = $portfolio;
        return $this;
    }

    public function getReviewedAt(): \DateTimeImmutable
    {
        return $this->reviewedAt;
    }
}
