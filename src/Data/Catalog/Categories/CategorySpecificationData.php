<?php

namespace Grebo87\LaravelVtexApi\Data\Catalog\Categories;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;

class CategorySpecificationData extends Data
{
    public function __construct(
        #[MapInputName('Name')]
        public readonly string $Name,

        #[MapInputName('CategoryId')]
        public readonly int $CategoryId,

        #[MapInputName('FieldId')]
        public readonly int $FieldId,

        #[MapInputName('IsActive')]
        public readonly bool $IsActive,

        #[MapInputName('IsStockKeepingUnit')]
        public readonly bool $IsStockKeepingUnit
    ) {
    }
}
