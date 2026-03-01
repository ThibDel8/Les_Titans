<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Http\Controller\Crud;

use App\MemberApp\Post\Domain\Entity\Post;
use App\MemberApp\Post\Domain\Handler\DeletePostHandler;
use App\SharedKernel\Domain\Voter\PostVoter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Requirement\Requirement;

final class DeletePostController extends AbstractController
{
    public function __construct(private readonly DeletePostHandler $deletePostHandler)
    {
    }

    #[Route(path: '/posts/{id}/delete', name: 'app_post_delete', requirements: ['id' => Requirement::UUID_V4], methods: [Request::METHOD_POST])]
    public function __invoke(Post $post): Response
    {
        $this->denyAccessUnlessGranted(attribute: PostVoter::DELETE, subject: $post); // voter

        $this->deletePostHandler->handle($post);

        $this->addFlash('success', 'La publication a bien été supprimée.');

        return $this->redirectToRoute('app_post_list');
    }
}
