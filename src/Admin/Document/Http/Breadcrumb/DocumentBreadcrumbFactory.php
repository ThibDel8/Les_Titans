<?php

declare(strict_types=1);

namespace App\Admin\Document\Http\Breadcrumb;

use App\Core\Http\Breadcrumb\BreadcrumbBuilder;

class DocumentBreadcrumbFactory
{
    public function adminDocuments(): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Administration', route: 'admin_dashboard')
            ->add(label: 'Documents')
            ->build();
    }
}
