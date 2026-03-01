<?php

declare(strict_types=1);

namespace App\PublicApp\Legals\Http\Controller;

use App\PublicApp\Legals\Http\Breadcrumb\PublicLegalsBreadcrumbFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class HouseRulesController extends AbstractController
{
    public function __construct(private readonly PublicLegalsBreadcrumbFactory $breadcrumbFactory)
    {
    }

    #[Route(path: '/house-rules', name: 'app_house_rules', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        return $this->render('legals/house-rules.html.twig', [
            'breadcrumbs' => $this->breadcrumbFactory->houseRules(),
        ]);
    }
}
