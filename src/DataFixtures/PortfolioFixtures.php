<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Allocation;
use App\Entity\InvestmentSnapshot;
use App\Entity\InvestmentType;
use App\Entity\Portfolio;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PortfolioFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Create investment types
        $coreEquity = new InvestmentType(
            'Core equity index',
            'Diversified market exposure for long-term capital growth.'
        );
        $bonds = new InvestmentType(
            'Investment-grade bonds',
            'Income stability with controlled duration and credit quality.'
        );
        $cash = new InvestmentType(
            'Cash and short duration reserves',
            'Liquidity for rebalancing windows and near-term opportunities.'
        );
        $alternatives = new InvestmentType(
            'Alternative strategies',
            'Selective exposure to real assets and uncorrelated return drivers.'
        );
        $tactical = new InvestmentType(
            'Tactical satellite positions',
            'Measured allocation for thesis-driven investment themes.'
        );

        $manager->persist($coreEquity);
        $manager->persist($bonds);
        $manager->persist($cash);
        $manager->persist($alternatives);
        $manager->persist($tactical);

        // Create a portfolio
        $portfolio = new Portfolio('Strategic Core Portfolio', new DateTimeImmutable('2026-05-19'));
        $portfolio->setDescription('A diversified multi-asset portfolio focused on long-term wealth accumulation with defensive characteristics.');
        $manager->persist($portfolio);

        // Create allocations for the portfolio
        $allocationCoreEquity = new Allocation(
            $portfolio,
            $coreEquity,
            '45.00',
            '8.50',
            'Moderate-High'
        );
        $allocationBonds = new Allocation(
            $portfolio,
            $bonds,
            '25.00',
            '4.25',
            'Low-Moderate'
        );
        $allocationCash = new Allocation(
            $portfolio,
            $cash,
            '15.00',
            '4.75',
            'Very Low'
        );
        $allocationAlternatives = new Allocation(
            $portfolio,
            $alternatives,
            '10.00',
            '6.50',
            'Moderate'
        );
        $allocationTactical = new Allocation(
            $portfolio,
            $tactical,
            '5.00',
            '7.25',
            'High'
        );

        $manager->persist($allocationCoreEquity);
        $manager->persist($allocationBonds);
        $manager->persist($allocationCash);
        $manager->persist($allocationAlternatives);
        $manager->persist($allocationTactical);

        // Create an investment snapshot
        $snapshot = new InvestmentSnapshot(
            $portfolio,
            new DateTimeImmutable('2026-05-19')
        );
        $manager->persist($snapshot);

        // Create additional portfolios for demo
        $conservativePortfolio = new Portfolio('Conservative Portfolio', new DateTimeImmutable('2026-05-15'));
        $conservativePortfolio->setDescription('A defensive portfolio emphasizing capital preservation and steady income.');
        $manager->persist($conservativePortfolio);

        $conservativeEquity = new Allocation(
            $conservativePortfolio,
            $coreEquity,
            '25.00',
            '6.50',
            'Low-Moderate'
        );
        $conservativeBonds = new Allocation(
            $conservativePortfolio,
            $bonds,
            '50.00',
            '3.75',
            'Very Low'
        );
        $conservativeCash = new Allocation(
            $conservativePortfolio,
            $cash,
            '20.00',
            '4.50',
            'Very Low'
        );
        $conservativeAlternatives = new Allocation(
            $conservativePortfolio,
            $alternatives,
            '5.00',
            '5.00',
            'Low'
        );

        $manager->persist($conservativeEquity);
        $manager->persist($conservativeBonds);
        $manager->persist($conservativeCash);
        $manager->persist($conservativeAlternatives);

        $conservativeSnapshot = new InvestmentSnapshot(
            $conservativePortfolio,
            new DateTimeImmutable('2026-05-15')
        );
        $manager->persist($conservativeSnapshot);

        $manager->flush();
    }
}
