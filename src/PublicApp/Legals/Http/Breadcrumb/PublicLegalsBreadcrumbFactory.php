<?php

declare(strict_types=1);

namespace App\PublicApp\Legals\Http\Breadcrumb;

use App\Core\Http\Breadcrumb\BreadcrumbBuilder;

class PublicLegalsBreadcrumbFactory
{
    public function houseRules(): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Règlements')
            ->build();
    }

    public function legalNotices(): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Mentions légales')
            ->build();
    }

    public function privacyPolicy(): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Politique de confidentialité')
            ->build();
    }
}
