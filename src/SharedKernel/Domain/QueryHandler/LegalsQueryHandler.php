<?php

declare(strict_types=1);

namespace App\SharedKernel\Domain\QueryHandler;

use App\SharedKernel\Domain\DTO\View\LegalsView;
use App\Admin\User\Domain\Repository\UserReadRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class LegalsQueryHandler
{
    public function __construct(private UserReadRepositoryInterface $userReadRepository)
    {
    }

    public function fetch(): LegalsView
    {
        $president = $this->userReadRepository->findPresident();

        if (null === $president) {
            throw new NotFoundHttpException(message: 'No president user found', code: 404);
        }

        return LegalsView::create(president: $president);
    }
}
