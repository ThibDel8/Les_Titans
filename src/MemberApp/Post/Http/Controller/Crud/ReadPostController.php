<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Http\Controller\Crud;

use App\Admin\User\Domain\Entity\User;
use App\MemberApp\Post\Domain\DTO\Request\CreateCommentRequest;
use App\MemberApp\Post\Domain\Entity\Post;
use App\MemberApp\Post\Domain\Handler\CreateCommentHandler;
use App\MemberApp\Post\Domain\Handler\ReadCommentHandler;
use App\MemberApp\Post\Http\Breadcrumb\MemberPostBreadcrumbFactory;
use App\MemberApp\Post\Http\Form\CreateCommentType;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ReadPostController extends AbstractController
{
    public function __construct(
        private readonly ReadCommentHandler $readCommentHandler,
        private readonly CreateCommentHandler $createCommentHandler,
        private readonly MemberPostBreadcrumbFactory $breadcrumbFactory,
    ) {
    }

    #[Route(path: '/posts/{id}', name: 'app_post_read', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function __invoke(Post $post, Request $request): Response
    {
        $this->denyAccessUnlessGranted(Role::Member->value);

        $createCommentRequest = new CreateCommentRequest();
        /** @var User $author */
        $author = $this->getUser();

        $form = $this->createForm(CreateCommentType::class, $createCommentRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createCommentHandler->handle($post, $author, $createCommentRequest);

            $this->addFlash('success', 'Votre commentaire a bien été publié.');

            return $this->redirectToRoute('app_post_read', ['id' => $post->getId()]);
        }

        $comments = $this->readCommentHandler->handle($post);

        return $this->render('posts/crud/read.html.twig', [
            'post' => $post,
            'form' => $form,
            'comments' => $comments,
            'breadcrumbs' => $this->breadcrumbFactory->readPost(),
        ]);
    }
}
