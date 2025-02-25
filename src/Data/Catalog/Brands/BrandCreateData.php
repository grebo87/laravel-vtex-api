<?php

namespace Grebo87\LaravelVtexApi\Data\Catalog\Brands;

use Spatie\LaravelData\Data;

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
