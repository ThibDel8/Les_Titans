<?php

declare(strict_types=1);

namespace App\Core\Http\Breadcrumb;

class BreadcrumbItem
{
    public function __construct(
        public string $label,
        public ?string $route = null,
        public array $parameters = [],
    ) {
    }
}
