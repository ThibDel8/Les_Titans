<?php

namespace App\Security\Http\Controller;

use App\Security\Domain\Handler\PasswordSetupHandler;
use App\Security\Domain\QueryHandler\PasswordSetupQuery;
use App\Security\Http\Form\PasswordSetupType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PasswordSetupController extends AbstractController
{
    public function __construct(
        private readonly PasswordSetupQuery $passwordSetupQuery,
        private readonly PasswordSetupHandler $passwordSetupHandler,
    ) {
    }

    #[Route('/password-setup/{token}', name: 'password_setup', requirements: ['token' => '[0-9a-f]{64}'], methods: [Request::METHOD_GET, Request::METHOD_POST])]
    public function setupPassword(string $token, Request $request): Response
    {
        $user = $this->passwordSetupQuery->getUserFromToken($token);

        $form = $this->createForm(PasswordSetupType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('plainPassword')->getData();

            $this->passwordSetupHandler->handle(user: $user, password: $password);

            $this->addFlash('success', 'Le mot de passe a bien été défini, vous pouvez maintenant vous connecter.');

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/password_setup.html.twig', [
            'form' => $form,
            'user' => $user,
        ]);
    }
}
