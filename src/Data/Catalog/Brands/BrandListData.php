<?php

namespace Grebo87\LaravelVtexApi\Data\Catalog\Brands;

use Spatie\LaravelData\Data;

class BrandListData extends Data
{
    public function __construct(
        public readonly ?int $id = null,
        public readonly string $name,
        public readonly bool $isActive = true,
        public readonly ?string $metaTagDescription = null,
        public readonly ?string $imageUrl = null,
        public readonly ?string $title = null
    ) {
    }
}
