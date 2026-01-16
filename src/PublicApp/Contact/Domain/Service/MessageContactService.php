<?php

declare(strict_types=1);

namespace App\PublicApp\Contact\Domain\Service;

use App\SharedKernel\Contact\Domain\Entity\Message;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MessageContactService
{
    public function __construct(
        private MailerInterface $mailer,
        private ParameterBagInterface $params,
    )
    {
    }

    public function sendContactMessage(Message $message): void
    {
        $email = (new TemplatedEmail())
            ->from($this->params->get('app.email'))
            ->to($this->params->get('manager1.email'))
            ->subject('Vous avez reçu un nouveau message de contact')
            ->htmlTemplate('emails/contact/new_message.html.twig')
            ->context([
                'email_address' => $message->getEmail(),
                'subject' => $message->getSubject(),
                'message' => $message->getMessage(),
            ]);

        $this->mailer->send($email);
    }
}
