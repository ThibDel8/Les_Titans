<?php

declare(strict_types=1);

namespace App\MemberApp\Post\Http\Breadcrumb;

use App\Core\Http\Breadcrumb\BreadcrumbBuilder;

class MemberPostBreadcrumbFactory
{
    public function createPost(): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Publications', route: 'app_post_list')
            ->add(label: 'Écrire une publication')
            ->build();
    }

    public function readPost(): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Publications', route: 'app_post_list')
            ->add(label: 'Commentaires')
            ->build();
    }

    public function listPosts(): array
    {
        return new BreadcrumbBuilder()
            ->add(label: 'Accueil', route: 'app_home')
            ->add(label: 'Publications')
            ->build();
    }
}
