<?php

namespace App\Controller;

use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'homepage', methods: ['GET'])]
    public function index(): Response
    {
        $portfolio = [
            [
                'label' => 'Core equity index',
                'allocation' => 45,
                'detail' => 'Diversified market exposure for long-term capital growth.',
            ],
            [
                'label' => 'Investment-grade bonds',
                'allocation' => 25,
                'detail' => 'Income stability with controlled duration and credit quality.',
            ],
            [
                'label' => 'Cash and short duration reserves',
                'allocation' => 15,
                'detail' => 'Liquidity for rebalancing windows and near-term opportunities.',
            ],
            [
                'label' => 'Alternative strategies',
                'allocation' => 10,
                'detail' => 'Selective exposure to real assets and uncorrelated return drivers.',
            ],
            [
                'label' => 'Tactical satellite positions',
                'allocation' => 5,
                'detail' => 'Measured allocation for thesis-driven investment themes.',
            ],
        ];

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

        return $this->render('home/index.html.twig', [
            'portfolio' => $portfolio,
            'principles' => $principles,
            'milestones' => $milestones,
            'reviewDate' => new DateTimeImmutable('2026-05-19'),
        ]);
    }
}
