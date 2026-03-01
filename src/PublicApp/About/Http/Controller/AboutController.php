<?php

declare(strict_types=1);

namespace App\PublicApp\About\Http\Controller;

use App\PublicApp\About\Http\Breadcrumb\PublicAboutBreadcrumbFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AboutController extends AbstractController
{
    public function __construct(private readonly PublicAboutBreadcrumbFactory $breadcrumbFactory)
    {
    }

    #[Route(path: '/about', name: 'app_about', methods: [Request::METHOD_GET])]
    public function __invoke(): Response
    {
        return $this->render('about/about.html.twig', [
            'breadcrumbs' => $this->breadcrumbFactory->about(),
        ]);
    }
}
