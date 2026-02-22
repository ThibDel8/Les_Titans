<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\Voter;

use App\Admin\User\Domain\Entity\User;
use App\MemberApp\Post\Domain\Entity\Comment;
use App\SharedKernel\Domain\Enum\Role;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;

class CommentVoter extends Voter
{
    public const string DELETE = 'delete';
    public const array ACTIONS = [
        self::DELETE,
    ];

    protected function supports(string $attribute, mixed $subject): bool
    {
        if (!in_array($attribute, self::ACTIONS)) {
            return false;
        }

        if (!$subject instanceof Comment) {
            return false;
        }

        return true;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token, ?Vote $vote = null): bool
    {
        $user = $token->getUser();

        if (!$user instanceof User) {
            $vote?->addReason('The user is not logged in.');

            return false;
        }

        return match($attribute) {
            self::DELETE => $this->canDelete($subject, $user, $vote),
            default => false,
        };
    }

    private function canDelete(Comment $comment, User $user, ?Vote $vote): bool
    {
        if (in_array($user->getRole(), Role::boardMembers(), true)) {
            return true;
        }

        if ($user === $comment->getAuthor()) {
            return true;
        }

        $vote?->addReason(sprintf(
            'The logged in user (user id: %s) is not the author of this comment (comment id: %d).',
            $user->getId(),
            $comment->getId()
        ));

        return false;
    }
}
