<?php

declare(strict_types=1);

namespace App\PublicApp\Membership\Domain\Service\Mailer;

use App\MemberApp\Membership\Domain\Entity\Membership;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

readonly class MembershipMailer
{
    public function __construct(
        private MailerInterface $mailer,
        private ParameterBagInterface $params,
        private UrlGeneratorInterface $urlGenerator,
    ) {
    }

    public function sendMembershipPdfDownload(Membership $membership): void
    {
        $email = new TemplatedEmail()
            ->from($this->params->get('app.email'))
            ->to($membership->getEmail())
            ->subject('Adhésion Saint-Ouen Musculation')
            ->htmlTemplate('emails/memberships/download_membership.html.twig')
            ->context([
                'membership' => $membership,
                'downloadUrl' => $this->urlGenerator->generate(
                    name: 'app_membership_download',
                    parameters: ['id' => $membership->getId()],
                    referenceType: UrlGeneratorInterface::ABSOLUTE_URL,
                ),
            ]);

        $this->mailer->send($email);
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function sendEmailNotificationToBoardMembers(Membership $membership, array $boardMemberEmails): void
    {
        $email = new TemplatedEmail()
            ->from($this->params->get('app.email'))
            ->to(...$boardMemberEmails)
            ->subject('Nouvelle demande d\'adhésion')
            ->htmlTemplate('emails/memberships/notification_new_membership.html.twig')
            ->context([
                'membership' => $membership,
                'age' => $membership->getAge(),
            ]);

        $this->mailer->send($email);
    }
}
