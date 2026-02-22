<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Http\Controller;

use App\MemberApp\Post\Domain\QueryHandler\ListPostQueryHandler;
use App\MemberApp\Post\Http\Breadcrumb\MemberPostBreadcrumbFactory;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ListPostController extends AbstractController
{
    public function __construct(
        private readonly ListPostQueryHandler $listPostQueryHandler,
        private readonly MemberPostBreadcrumbFactory $breadcrumbFactory,
    ) {
    }

    #[Route(path: '/posts', name: 'app_post_list', methods: Request::METHOD_GET)]
    public function __invoke(): Response
    {
        $this->denyAccessUnlessGranted(Role::Member->value);

        $posts = $this->listPostQueryHandler->fetch();

        return $this->render('posts/list.html.twig', [
            'posts' => $posts,
            'breadcrumbs' => $this->breadcrumbFactory->listPosts(),
        ]);
    }
}
