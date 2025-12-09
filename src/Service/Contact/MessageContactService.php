<?php

declare(strict_types=1);

namespace App\Service\Contact;

use App\Entity\Contact\Message;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class MessageContactService
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function send(Message $message): void
    {
        $email = (new Email())
            ->from('hello@example.com')
            ->to($message->getEmail())
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject($message->getSubject())
            ->text($message->getMessage());

        $this->mailer->send($email);
    }
}
