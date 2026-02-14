<?php

declare(strict_types=1);

namespace App\PublicApp\Contact\Domain\Service;

use App\PublicApp\Contact\Domain\Entity\ContactMessage;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

readonly class ContactMessageContactService
{
    public function __construct(
        private MailerInterface $mailer,
        private ParameterBagInterface $params,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendContactMessage(ContactMessage $message, array $boardMemberEmails): void
    {
        $email = new TemplatedEmail()
            ->from($this->params->get('app.email'))
            ->to(...$boardMemberEmails)
            ->subject('Vous avez reçu un nouveau message de contact')
            ->htmlTemplate('emails/contact/new_message.html.twig')
            ->context([
                'email_address' => $message->getEmail(),
                'subject' => $message->getSubject(),
                'message' => $message->getBody(),
            ]);

        $this->mailer->send($email);
    }
}
