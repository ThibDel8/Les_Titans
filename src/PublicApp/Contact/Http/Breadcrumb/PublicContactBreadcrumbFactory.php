<?php

declare(strict_types=1);

namespace App\PublicApp\Contact\Http\Breadcrumb;

use App\Core\Http\Breadcrumb\BreadcrumbBuilder;

class PublicContactBreadcrumbFactory
{
    public function createContactMessage(): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Contact')
            ->build();
    }
}
