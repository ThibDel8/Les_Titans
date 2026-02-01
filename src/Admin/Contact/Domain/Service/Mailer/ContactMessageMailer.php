<?php

declare(strict_types=1);

namespace App\Admin\Contact\Domain\Service\Mailer;

use App\PublicApp\Contact\Domain\Entity\ContactMessage;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\MailerInterface;

class ContactMessageMailer
{
    public function __construct(
        private MailerInterface $mailer,
        private ParameterBagInterface $params,
    ) {
    }

    public function sendAnswer(ContactMessage $contactMessage): void
    {
        $email = new TemplatedEmail()
            ->from($this->params->get('app.email'))
            ->to($contactMessage->getEmail())
            ->subject('Contact Saint-Ouen Musculation')
            ->htmlTemplate('emails/contact/answer.html.twig')
            ->context([
                'message' => $contactMessage,
            ]);

        $this->mailer->send($email);
    }
}
