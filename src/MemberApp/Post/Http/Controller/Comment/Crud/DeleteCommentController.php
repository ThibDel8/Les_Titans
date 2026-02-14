<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Http\Controller\Comment\Crud;

use App\MemberApp\Post\Domain\Entity\Comment;
use App\MemberApp\Post\Domain\Handler\DeleteCommentHandler;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DeleteCommentController extends AbstractController
{
    public function __construct(private readonly DeleteCommentHandler $deleteCommentHandler)
    {
    }

    #[Route(path: '/posts/comments/{id}/delete', name: 'app_post_comment_delete', requirements: ['id' => '[0-9a-fA-F\-]{36}'], methods:Request::METHOD_POST)]
    public function __invoke(Comment $comment): Response
    {
        $this->denyAccessUnlessGranted(Role::Member->value);

        $this->deleteCommentHandler->handle($comment);

        $this->addFlash('success', 'Le commentaire a bien été supprimé.');

        return $this->redirectToRoute('app_post_read', ['id' => $comment->getPost()->getId()]);
    }
}
