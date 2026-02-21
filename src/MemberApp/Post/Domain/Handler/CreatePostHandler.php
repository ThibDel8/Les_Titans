<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Domain\Handler;

use App\Admin\User\Domain\Entity\User;
use App\Admin\User\Domain\Repository\UserReadRepositoryInterface;
use App\MemberApp\Post\Domain\DTO\Request\CreatePostRequest;
use App\MemberApp\Post\Domain\Entity\Post;
use App\MemberApp\Post\Domain\Repository\PostWriteRepositoryInterface;
use App\MemberApp\Post\Domain\Service\Mailer\MemberMailer;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

readonly class CreatePostHandler
{
    public function __construct(
        private MemberMailer $memberMailer,
        private UrlGeneratorInterface $urlGenerator,
        private UserReadRepositoryInterface $userReadRepository,
        private PostWriteRepositoryInterface $postWriteRepository,
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function handle(CreatePostRequest $createPostRequest, User $author): void
    {
        $post = Post::create(
            author: $author,
            text: $createPostRequest->text,
            attachments: $createPostRequest->attachments ?? [],
            linkPreview: $createPostRequest->linkPreview ?? [],
        );

        $this->postWriteRepository->save($post);

        if ($author->getUserRole()->isBoardMember()) {
            $memberEmails = $this->getAllMemberEmails($author);
            $postUrl = $this->urlGenerator->generate(
                name: 'app_post_read',
                parameters: ['id' => $post->getId()],
                referenceType: UrlGeneratorInterface::ABSOLUTE_URL,
            );
            $this->memberMailer->sendToAllMembers($memberEmails, $author, $postUrl);
        }
    }

    private function getAllMemberEmails(User $author): array
    {
        $allEmails = $this->userReadRepository->findAllMemberEmails();
        $memberEmails = array_column($allEmails, 'email');

        $excludedEmail = $author->getEmail();

        $filteredEmails = array_filter(
            array: $memberEmails,
            callback: fn ($email) => $email !== $excludedEmail,
        );

        return array_map(
            callback: fn ($email) => new Address($email),
            array: $filteredEmails,
        );
    }
}
