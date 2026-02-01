<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Http\Controller;

use App\MemberApp\Post\Domain\QueryHandler\ListPostQueryHandler;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ListPostController extends AbstractController
{
    public function __construct(private readonly ListPostQueryHandler $listPostQueryHandler)
    {
    }

    #[Route(path: '/posts', name: 'app_post_list', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $this->denyAccessUnlessGranted(Role::Member->value);

        $posts = $this->listPostQueryHandler->fetch();

        $breadcrumb = [
            ['label' => 'Accueil', 'path' => $this->generateUrl('app_home')],
            ['label' => 'Publications', 'path' => null],
        ];

        return $this->render('posts/list.html.twig', [
            'breadcrumb' => $breadcrumb,
            'posts' => $posts,
        ]);
    }
}
