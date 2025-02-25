<?php

namespace Grebo87\LaravelVtexApi\Data\Catalog\Categories;

use Spatie\LaravelData\Data;

class CategoryTreeData extends Data
{
    public function __construct(
        public readonly int $id,
        public readonly string $name,
        public readonly bool $hasChildren,
        public readonly string $url,
        public readonly array $children,
        public readonly ?string $Title = null,
        public readonly ?string $MetaTagDescription = null
    ) {
    }
}
