<?php

declare(strict_types=1);

namespace App\MemberApp\Profile\Http\Controller\Crud;

use App\Admin\User\Domain\Entity\User;
use App\MemberApp\Profile\Domain\DTO\Request\ProfileRequest;
use App\MemberApp\Profile\Domain\Handler\UpdateProfileHandler;
use App\MemberApp\Profile\Http\Breadcrumb\MemberProfileBreadcrumbFactory;
use App\MemberApp\Profile\Http\Controller\Form\ProfileType;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class UpdateUserProfileController extends AbstractController
{
    public function __construct(
        private readonly UpdateProfileHandler $updateProfileHandler,
        private readonly MemberProfileBreadcrumbFactory $breadcrumbFactory,
    ) {
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

        return $this->render('profile/crud/update.html.twig', [
            'form' => $form,
            'breadcrumbs' => $this->breadcrumbFactory->updateProfile(),
        ]);
    }
}
