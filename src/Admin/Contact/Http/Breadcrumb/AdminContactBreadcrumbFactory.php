<?php

declare(strict_types=1);

namespace App\Admin\Contact\Http\Breadcrumb;

use App\Core\Http\Breadcrumb\BreadcrumbBuilder;

class AdminContactBreadcrumbFactory
{
    public function readContactMessage(): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Administration', route: 'admin_dashboard')
            ->add(label: 'Liste des messages', route: 'admin_contact_message_list')
            ->add(label: 'Messages')
            ->build();
    }

    public function listContactMessage(): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Administration', route: 'admin_dashboard')
            ->add(label: 'Liste des messages')
            ->build();
    }
}
