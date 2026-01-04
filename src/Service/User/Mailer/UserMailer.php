<?php

declare(strict_types=1);

namespace App\Service\User\Mailer;

use App\Entity\Security\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class UserMailer
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function sendPasswordSetupEmail(User $user): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address('test@email.fr', 'Saint-Ouen Musculation'))
            ->to($user->getEmail())
            ->subject('Création de votre compte - Choisissez votre mot de passe')
            ->htmlTemplate('emails/password_setup.html.twig')
            ->context([
                'user' => $user,
                'token' => $user->getPasswordSetupToken(),
            ]);

        $this->mailer->send($email);
    }
}
