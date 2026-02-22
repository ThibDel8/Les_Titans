<?php

declare(strict_types=1);

namespace App\PublicApp\About\Http\Breadcrumb;

use App\Core\Http\Breadcrumb\BreadcrumbBuilder;

class PublicAboutBreadcrumbFactory
{
    public function about(): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'À propos')
            ->build();
    }
}
