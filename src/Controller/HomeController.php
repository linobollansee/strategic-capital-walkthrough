<?php

namespace App\Controller;

use App\Repository\PortfolioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage', methods: ['GET'])]
    public function index(PortfolioRepository $portfolioRepository): Response
    {
        // Fetch the primary portfolio from the database
        $mainPortfolio = $portfolioRepository->findOneBy(['name' => 'Strategic Core Portfolio']);

        // Transform allocations into portfolio array format
        $portfolio = [];
        if ($mainPortfolio) {
            foreach ($mainPortfolio->getAllocations() as $allocation) {
                $portfolio[] = [
                    'label' => $allocation->getInvestmentType()->getName(),
                    'allocation' => (float) $allocation->getPercentage(),
                    'detail' => $allocation->getInvestmentType()->getDescription(),
                    'expectedReturn' => (float) $allocation->getExpectedAnnualReturn(),
                    'riskBand' => $allocation->getRiskBand(),
                ];
            }
        }

        $principles = [
            'Define the investment horizon before selecting instruments.',
            'Match risk budget to the client objective and liquidity profile.',
            'Rebalance on discipline, not on recent market sentiment.',
            'Document assumptions so every allocation choice can be reviewed.',
        ];

        $milestones = [
            ['label' => 'Strategy brief', 'value' => 'Objectives, constraints, and return targets'],
            ['label' => 'Portfolio design', 'value' => 'Asset mix, exposure limits, and rebalancing rules'],
            ['label' => 'Implementation', 'value' => 'Brokerage setup, deposits, and execution checklist'],
            ['label' => 'Review cycle', 'value' => 'Quarterly review against benchmark and cash needs'],
        ];

        // Get review date from the latest snapshot or fall back to today
        $reviewDate = new \DateTimeImmutable('now');
        if ($mainPortfolio) {
            $snapshots = $mainPortfolio->getSnapshots();
            if (!$snapshots->isEmpty()) {
                $reviewDate = $snapshots->last()->getReviewedAt();
            }
        }

        return $this->render('home/index.html.twig', [
            'portfolio' => $portfolio,
            'principles' => $principles,
            'milestones' => $milestones,
            'reviewDate' => $reviewDate,
            'portfolioName' => $mainPortfolio ? $mainPortfolio->getName() : 'Strategic Portfolio',
            'portfolioDescription' => $mainPortfolio ? $mainPortfolio->getDescription() : '',
        ]);
    }
}
