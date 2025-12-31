<?php

namespace App\Controller\Security;

use App\Form\Security\PasswordSetupType;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\Security\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class PasswordSetupController extends AbstractController
{
    #[Route('/password-setup/{token}', name: 'password_setup')]
    public function setupPassword(string $token, Request $request, UserRepository $userRepository, UserPasswordHasherInterface $hasher, EntityManagerInterface $em)
    {
        $user = $userRepository->findOneBy(['passwordSetupToken' => $token]);

        if (!$user) {
            throw $this->createNotFoundException('Token invalide.');
        }

        if ($user->getPasswordSetupTokenExpiresAt() < new \DateTimeImmutable()) {
            throw $this->createAccessDeniedException('Le token a expiré.');
        }

        $form = $this->createForm(PasswordSetupType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $form->get('plainPassword')->getData();
            $user->setPassword($hasher->hashPassword($user, $password));

            $user->setPasswordSetupToken(null);
            $user->setPasswordSetupTokenExpiresAt(null);

            $em->flush();

            $this->addFlash('success', 'Mot de passe défini, vous pouvez maintenant vous connecter.');
            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/password_setup.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
