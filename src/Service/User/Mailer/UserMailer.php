<?php

declare(strict_types=1);

namespace App\Service\User\Mailer;

use App\Entity\Security\User;
use Symfony\Component\Mime\Address;
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
        $email = (new TemplatedEmail())
            ->from($this->params->get('app.email'))
            ->to($user->getEmail())
            ->subject('Manager Saint-Ouen Musculation')
            ->htmlTemplate('emails/security/password_setup.html.twig')
            ->context([
                'user' => $user,
                'token' => $user->getPasswordSetupToken(),
            ]);

        $this->mailer->send($email);
    }
}
