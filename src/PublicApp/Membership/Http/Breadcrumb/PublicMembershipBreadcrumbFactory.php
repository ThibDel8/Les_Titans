<?php

declare(strict_types=1);

namespace App\PublicApp\Membership\Http\Breadcrumb;

use App\Core\Http\Breadcrumb\BreadcrumbBuilder;

class PublicMembershipBreadcrumbFactory
{
    public function createMembership(): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Demande d\'adhésion')
            ->build();
    }

    public function pendingMembership(): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Demande d\'adhésion')
            ->build();
    }
}
