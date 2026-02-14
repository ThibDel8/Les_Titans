<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Http\Controller\Crud;

use App\MemberApp\Post\Domain\Entity\Post;
use App\MemberApp\Post\Domain\Handler\DeletePostHandler;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeletePostController extends AbstractController
{
    public function __construct(private readonly DeletePostHandler $deletePostHandler)
    {
    }

    #[Route(path: '/posts/{id}/delete', name: 'app_post_delete', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods:Request::METHOD_POST)]
    public function __invoke(Post $post): Response
    {
        $this->denyAccessUnlessGranted(Role::Member->value);

        $this->deletePostHandler->handle($post);

        $this->addFlash('success', 'La publication a bien été supprimée.');

        return $this->redirectToRoute('app_post_list');
    }
}
