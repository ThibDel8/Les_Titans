<?php

declare(strict_types=1);

namespace App\Admin\Dashboard\Http\Breadcrumb;

use App\Core\Http\Breadcrumb\BreadcrumbBuilder;

class AdminDashboardBreadcrumbFactory
{
    public function dashboard(): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Administration')
            ->build();
    }
}
