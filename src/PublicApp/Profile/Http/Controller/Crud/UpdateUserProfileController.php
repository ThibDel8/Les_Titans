<?php

declare(strict_types=1);

namespace App\PublicApp\Profile\Http\Controller\Crud;

use App\Admin\User\Domain\Entity\User;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\PublicApp\Profile\Http\Controller\Form\ProfileType;
use App\PublicApp\Profile\Domain\DTO\Request\ProfileRequest;
use App\PublicApp\Profile\Domain\Handler\UpdateProfileHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UpdateUserProfileController extends AbstractController
{
    public function __construct(private UpdateProfileHandler $updateProfileHandler)
    {
    }

    #[Route(path: '/profile/edit', name: 'app_profile_edit', methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function __invoke(Request $request): Response
    {
        $this->denyAccessUnlessGranted(Role::Member->value);

        /** @var User $user */
        $user = $this->getUser();
        $profileRequest = ProfileRequest::fromEntity($user);

        $form = $this->createForm(ProfileType::class, $profileRequest, ['is_minor' => 18 > $user->getAge()]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $this->updateProfileHandler->handle($user, $profileRequest);

            $this->addFlash('success', 'Votre profil a été mis à jour avec succès.');

            return $this->redirectToRoute('app_profile_read');
        }

        $breadcrumb = [
            ['label' => 'Accueil', 'path' => $this->generateUrl('app_home')],
            ['label' => 'Profil', 'path' => $this->generateUrl('app_profile_read')],
            ['label' => 'Modifications', 'path' => null],
        ];


        return $this->render('profile/crud/update.html.twig', [
            'form' => $form,
            'breadcrumb' => $breadcrumb,
        ]);
    }
}
