<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Domain\Service\Mailer;

use App\Admin\User\Domain\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

readonly class MemberMailer
{
    public function __construct(
        private MailerInterface $mailer,
        private ParameterBagInterface $params,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendToAllMembers(array $memberEmails, User $author, string $postUrl): void
    {
        $email = new TemplatedEmail()
            ->from($this->params->get('app.email'))
            ->to(...$memberEmails)
            ->subject('Nouvelle Publication Les Titans')
            ->htmlTemplate('emails/posts/new_board_member_post.html.twig')
            ->context([
                'author' => $author,
                'postUrl' => $postUrl,
            ]);

        $this->mailer->send($email);
    }
}
