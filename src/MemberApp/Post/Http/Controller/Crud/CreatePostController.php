<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Http\Controller\Crud;

use App\Admin\User\Domain\Entity\User;
use App\MemberApp\Post\Domain\DTO\Request\CreatePostRequest;
use App\MemberApp\Post\Domain\Handler\CreatePostHandler;
use App\MemberApp\Post\Http\Form\CreatePostType;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CreatePostController extends AbstractController
{
    public function __construct(private readonly CreatePostHandler $createPostHandler)
    {
    }

    #[Route(path: '/posts/create', name: 'app_post_create', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function __invoke(Request $request): Response
    {
        $this->denyAccessUnlessGranted(Role::Member->value);

        $createPostRequest = new CreatePostRequest();
        /** @var User $author */
        $author = $this->getUser();

        $form = $this->createForm(CreatePostType::class, $createPostRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->createPostHandler->handle($createPostRequest, $author);

            $this->addFlash('success', 'Votre message a bien été publié.');

            return $this->redirectToRoute('app_post_list');
        }

        $breadcrumb = [
            ['label' => 'Accueil', 'path' => $this->generateUrl('app_home')],
            ['label' => 'Publications', 'path' => $this->generateUrl('app_post_list')],
            ['label' => 'Écrire une publication', 'path' => null],
        ];

        return $this->render('posts/crud/create.html.twig', [
            'breadcrumb' => $breadcrumb,
            'form' => $form,
        ]);
    }
}
