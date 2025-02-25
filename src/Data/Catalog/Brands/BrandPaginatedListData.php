<?php

namespace Grebo87\LaravelVtexApi\Data\Catalog\Brands;

use Spatie\LaravelData\Data;


class BrandPaginatedListData extends Data
{
    public function __construct(
        public readonly array $items,
        public readonly BrandPagingData $paging,
    ) {
    }
}
