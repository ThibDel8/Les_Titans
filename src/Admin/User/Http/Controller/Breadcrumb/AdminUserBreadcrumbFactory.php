<?php

declare(strict_types=1);

namespace App\Admin\User\Http\Controller\Breadcrumb;

use App\Admin\User\Domain\Entity\User;
use App\Core\Http\Breadcrumb\BreadcrumbBuilder;

class AdminUserBreadcrumbFactory
{
    public function listUsers(): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Administration', route: 'admin_dashboard')
            ->add(label: 'Liste des membres')
            ->build();
    }

    public function readUser(User $user): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Administration', route: 'admin_dashboard')
            ->add(label: 'Liste des membres', route: 'admin_user_list')
            ->add(label: $user->getFirstname().' '.$user->getLastname())
            ->build();
    }

    public function updateUser(User $user): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Administration', route: 'admin_dashboard')
            ->add(label: 'Liste des membres', route: 'admin_user_list')
            ->add(label: $user->getFirstname().' '.$user->getLastname(), route: 'admin_user_read', parameters: ['id' => $user->getId()])
            ->add(label: 'Modifications')
            ->build();
    }
}
