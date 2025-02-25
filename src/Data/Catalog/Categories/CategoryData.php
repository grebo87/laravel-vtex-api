<?php

namespace Grebo87\LaravelVtexApi\Data\Catalog\Categories;

use Spatie\LaravelData\Data;
use Spatie\LaravelData\Attributes\MapInputName;

class CategoryData extends Data
{
    public function __construct(
        #[MapInputName('Name')]
        public readonly string $Name,

        #[MapInputName('Title')]
        public readonly string $Title,

        #[MapInputName('Description')]
        public readonly string $Description,

        #[MapInputName('Id')]
        public readonly ?int $Id = null,

        #[MapInputName('FatherCategoryId')]
        public readonly ?int $FatherCategoryId = null,

        #[MapInputName('Keywords')]
        public readonly ?string $Keywords = null,

        #[MapInputName('IsActive')]
        public readonly bool $IsActive = true,

        #[MapInputName('LomadeeCampaignCode')]
        public readonly ?string $LomadeeCampaignCode = null,

        #[MapInputName('AdWordsRemarketingCode')]
        public readonly ?string $AdWordsRemarketingCode = null,

        #[MapInputName('ShowInStoreFront')]
        public readonly bool $ShowInStoreFront = true,

        #[MapInputName('ShowBrandFilter')]
        public readonly bool $ShowBrandFilter = true,

        #[MapInputName('ActiveStoreFrontLink')]
        public readonly bool $ActiveStoreFrontLink = true,

        #[MapInputName('GlobalCategoryId')]
        public readonly ?int $GlobalCategoryId = null,

        #[MapInputName('StockKeepingUnitSelectionMode')]
        public readonly string $StockKeepingUnitSelectionMode = 'SPECIFICATION',

        #[MapInputName('Score')]
        public readonly ?int $Score = null,

        #[MapInputName('LinkId')]
        public readonly ?string $LinkId = null,

        #[MapInputName('HasChildren')]
        public readonly ?bool $HasChildren = null
    ) {
    }
}
