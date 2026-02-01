<?php

declare(strict_types=1);

namespace App\Admin\User\Domain\Service\Mailer;

use App\Admin\User\Domain\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class UserMailer
{
    public function __construct(
        private MailerInterface $mailer,
        private ParameterBagInterface $params,
    ) {
    }

    public function sendPasswordSetupEmail(User $user): void
    {
        $email = new TemplatedEmail()
            ->from($this->params->get('app.email'))
            ->to($user->getEmail())
            ->subject('Les Titans | Inscription validée')
            ->htmlTemplate('emails/security/password_setup.html.twig')
            ->context([
                'user' => $user,
                'token' => $user->getPasswordSetupToken(),
            ]);

        $this->mailer->send($email);
    }

    public function notifyPresidentOfUserDeletion(User $user, User $president): void
    {
        $email = new TemplatedEmail()
            ->from($this->params->get('app.email'))
            ->to($president->getEmail())
            ->subject('Les Titans | Suppression d\'un memebre dirigeant')
            ->htmlTemplate('emails/user/manager_deletion.html.twig')
            ->context([
                'user' => $user,
                'president' => $president,
            ]);

        $this->mailer->send($email);
    }
}
