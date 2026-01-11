<?php

namespace App\Controller\Security;

use App\Form\Security\PasswordSetupType;
use App\Handler\Security\PasswordSetupHandler;
use App\QueryHandler\Security\PasswordSetupQuery;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
