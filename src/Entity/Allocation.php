<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'allocation')]
class Allocation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'allocations')]
    #[ORM\JoinColumn(nullable: false)]
    private Portfolio $portfolio;

    #[ORM\ManyToOne(inversedBy: 'allocations')]
    #[ORM\JoinColumn(name: 'investment_type_id', nullable: false)]
    private InvestmentType $investmentType;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private string $percentage;

    #[ORM\Column(name: 'expected_annual_return', type: Types::DECIMAL, precision: 5, scale: 2)]
    private string $expectedAnnualReturn;

    #[ORM\Column(name: 'risk_band', length: 32)]
    private string $riskBand;

    public function __construct(Portfolio $portfolio, InvestmentType $investmentType, string $percentage, string $expectedAnnualReturn, string $riskBand)
    {
        $this->portfolio = $portfolio;
        $this->investmentType = $investmentType;
        $this->percentage = $percentage;
        $this->expectedAnnualReturn = $expectedAnnualReturn;
        $this->riskBand = $riskBand;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPortfolio(): Portfolio
    {
        return $this->portfolio;
    }

    public function setPortfolio(Portfolio $portfolio): self
    {
        $this->portfolio = $portfolio;
        return $this;
    }

    public function getInvestmentType(): InvestmentType
    {
        return $this->investmentType;
    }

    public function setInvestmentType(InvestmentType $investmentType): self
    {
        $this->investmentType = $investmentType;
        return $this;
    }

    public function getPercentage(): string
    {
        return $this->percentage;
    }

    public function setPercentage(string $percentage): self
    {
        $this->percentage = $percentage;
        return $this;
    }

    public function getExpectedAnnualReturn(): string
    {
        return $this->expectedAnnualReturn;
    }

    public function setExpectedAnnualReturn(string $expectedAnnualReturn): self
    {
        $this->expectedAnnualReturn = $expectedAnnualReturn;
        return $this;
    }

    public function getRiskBand(): string
    {
        return $this->riskBand;
    }

    public function setRiskBand(string $riskBand): self
    {
        $this->riskBand = $riskBand;
        return $this;
    }
}
