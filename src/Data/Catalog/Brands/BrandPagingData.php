<?php

namespace Grebo87\LaravelVtexApi\Data\Catalog\Brands;

use Spatie\LaravelData\Data;


class BrandPagingData extends Data
{
    public function __construct(
        public readonly int $page,
        public readonly int $perPage,
        public readonly int $total,
        public readonly int $pages,
    ) {
    }
}
