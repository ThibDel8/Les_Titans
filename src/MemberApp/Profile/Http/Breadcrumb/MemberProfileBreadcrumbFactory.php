<?php

declare(strict_types=1);

namespace App\MemberApp\Profile\Http\Breadcrumb;

use App\Core\Http\Breadcrumb\BreadcrumbBuilder;

class MemberProfileBreadcrumbFactory
{
    public function createProfile(): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Profil')
            ->build();
    }

    public function updateProfile(): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Profil', route: 'app_profile_read')
            ->add(label: 'Modifications')
            ->build();
    }
}
