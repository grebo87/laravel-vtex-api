<?php

namespace Grebo87\LaravelVtexApi\Data\Catalog\Brands;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\MapOutputName;
use Spatie\LaravelData\Attributes\Validation\IntegerType;
use Spatie\LaravelData\Attributes\Validation\StringType;
use Spatie\LaravelData\Attributes\Validation\BooleanType;
use Spatie\LaravelData\Attributes\Validation\Required;
use Spatie\LaravelData\Attributes\Validation\Min;
use Spatie\LaravelData\Attributes\Validation\Max;

class BrandCreateData extends Data
{
    public function __construct(
        public readonly ?int $id = null,
        public readonly string $name,
        public readonly ?string $text = null,
        public readonly ?string $keywords = null,
        public readonly ?string $siteTitle = null,
        public readonly bool $active = true,
        public readonly bool $menuHome = false,
        public readonly ?string $adWordsRemarketingCode = null,
        public readonly ?string $lomadeeCampaignCode = null,
        public readonly ?int $score = null,
        public readonly ?string $linkId = null,
    ) {
    }
}
