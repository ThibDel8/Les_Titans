<?php

declare(strict_types=1);

namespace App\PublicApp\Contact\Domain\Handler;

use App\Admin\User\Domain\Repository\UserReadRepositoryInterface;
use App\PublicApp\Contact\Domain\DTO\Request\ContactMessageCreationRequest;
use App\PublicApp\Contact\Domain\Entity\ContactMessage;
use App\PublicApp\Contact\Domain\Repository\ContactMessageWriteRepositoryInterface;
use App\PublicApp\Contact\Domain\Service\ContactMessageContactService;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;

final readonly class CreateContactMessageHandler
{
    public function __construct(
        private UserReadRepositoryInterface $userReadRepository,
        private ContactMessageContactService $messageContactService,
        private ContactMessageWriteRepositoryInterface $messageWriteRepository,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function handle(ContactMessageCreationRequest $request): void
    {
        $message = ContactMessage::create(
            email: $request->email,
            subject: $request->subject,
            body: $request->body,
        );

        $this->messageWriteRepository->save($message);

        $boardMemberEmails = $this->getBoardMemberEmails();

        $this->messageContactService->sendContactMessage($message, $boardMemberEmails);
    }

    private function getBoardMemberEmails(): array
    {
        $boardMembers = $this->userReadRepository->getBoardMembers();

        $boardMemberEmails = [];
        foreach ($boardMembers as $member) {
            $boardMemberEmails[] = $member->getEmail();
        }

        return Address::createArray($boardMemberEmails);
    }
}
