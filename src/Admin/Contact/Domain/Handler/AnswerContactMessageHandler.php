<?php

declare(strict_types=1);

namespace App\Admin\Contact\Domain\Handler;

use App\Admin\Contact\Domain\DTO\Request\AnswerContactMessageRequest;
use App\Admin\Contact\Domain\Service\Mailer\ContactMessageMailer;
use App\Admin\User\Domain\Entity\User;
use App\PublicApp\Contact\Domain\Entity\ContactMessage;
use App\PublicApp\Contact\Domain\Repository\ContactMessageWriteRepositoryInterface;

final readonly class AnswerContactMessageHandler
{
    public function __construct(
        private ContactMessageMailer $mailer,
        private ContactMessageWriteRepositoryInterface $contactMessageWriteRepository,
    ) {
    }

    public function handle(ContactMessage $contactMessage, AnswerContactMessageRequest $request, User $answeredBy): void
    {
        $contactMessage->saveAnswer($request->answer, $answeredBy);

        $this->contactMessageWriteRepository->save($contactMessage);

        $this->mailer->sendAnswer($contactMessage);
    }
}
