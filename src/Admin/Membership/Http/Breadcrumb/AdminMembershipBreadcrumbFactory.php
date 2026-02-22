<?php

declare(strict_types=1);

namespace App\Admin\Membership\Http\Breadcrumb;

use App\Core\Http\Breadcrumb\BreadcrumbBuilder;
use App\MemberApp\Membership\Domain\Entity\Membership;

class AdminMembershipBreadcrumbFactory
{
    public function listMemberships(): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Administration', route: 'admin_dashboard')
            ->add(label: 'Liste des demandes d\'adhésion')
            ->build();
    }

    public function readMembership(Membership $membership): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Administration', route: 'admin_dashboard')
            ->add(label: 'Liste des demandes d\'adhésion', route: 'admin_membership_list')
            ->add(label: $membership->getFirstname().' '.$membership->getLastname())
            ->build();
    }
}
