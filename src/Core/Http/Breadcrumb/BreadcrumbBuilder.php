<?php

declare(strict_types=1);

namespace App\Core\Http\Breadcrumb;

class BreadcrumbBuilder
{
    /** @var BreadcrumbItem[] */
    private array $items = [];

    public function add(string $label, ?string $route = null, array $parameters = []): self
    {
        $this->items[] = new BreadcrumbItem($label, $route, $parameters);

        return $this;
    }

    /**
     * @return BreadcrumbItem[]
     */
    public function build(): array
    {
        return $this->items;
    }
}
