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

    #[ORM\Column(length: 180)]
    private string $portfolioName;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private string $allocation;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private string $expectedAnnualReturn;

    #[ORM\Column(length: 32)]
    private string $riskBand;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $reviewedAt;

    public function __construct(string $portfolioName, string $allocation, string $expectedAnnualReturn, string $riskBand, \DateTimeImmutable $reviewedAt)
    {
        $this->portfolioName = $portfolioName;
        $this->allocation = $allocation;
        $this->expectedAnnualReturn = $expectedAnnualReturn;
        $this->riskBand = $riskBand;
        $this->reviewedAt = $reviewedAt;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPortfolioName(): string
    {
        return $this->portfolioName;
    }

    public function getAllocation(): string
    {
        return $this->allocation;
    }

    public function getExpectedAnnualReturn(): string
    {
        return $this->expectedAnnualReturn;
    }

    public function getRiskBand(): string
    {
        return $this->riskBand;
    }

    public function getReviewedAt(): \DateTimeImmutable
    {
        return $this->reviewedAt;
    }
}
