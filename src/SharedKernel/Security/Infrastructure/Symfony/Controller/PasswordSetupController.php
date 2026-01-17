<?php

namespace App\SharedKernel\Security\Infrastructure\Symfony\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\SharedKernel\Security\Domain\Handler\PasswordSetupHandler;
use App\SharedKernel\Security\Domain\QueryHandler\PasswordSetupQuery;
use App\SharedKernel\Security\Infrastructure\Symfony\Form\PasswordSetupType;

class PasswordSetupController extends AbstractController
{
    public function __construct(
        private PasswordSetupQuery $passwordSetupQuery,
        private PasswordSetupHandler $passwordSetupHandler,
    ) {
    }

    #[Route('/password-setup/{token}', name: 'password_setup')]
    public function setupPassword(string $token, Request $request)
    {
        $user = $this->passwordSetupQuery->getUserFromToken($token);

        $form = $this->createForm(PasswordSetupType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('plainPassword')->getData();

            $this->passwordSetupHandler->handle(user: $user, password: $password);

            $this->addFlash('success', 'Le mot de passe a été défini avec succès, vous pouvez maintenant vous connecter.');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/password_setup.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }
}
