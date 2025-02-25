<?php

namespace Tests\Unit\Services\Catalog;

use Grebo87\LaravelVtexApi\Data\Catalog\Brands\BrandListData;
use Grebo87\LaravelVtexApi\Data\Catalog\Brands\BrandCreateData;
use Grebo87\LaravelVtexApi\Data\Catalog\Brands\BrandPaginatedListData;
use Grebo87\LaravelVtexApi\Data\Catalog\Brands\BrandPagingData;
use Grebo87\LaravelVtexApi\Services\Catalog\BrandService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Grebo87\LaravelVtexApi\Providers\LaravelVtexApiServiceProvider;
use Orchestra\Testbench\TestCase;

class BrandServiceTest extends TestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            LaravelVtexApiServiceProvider::class,
        ];
    }
    private BrandService $brandService;
    protected function setUp(): void
    {
        parent::setUp();

        // Configurar variables de entorno para las pruebas
        config([
            'vtex.app_key' => 'test-app-key',
            'vtex.app_token' => 'test-app-token',
            'vtex.account_name' => 'test-store',
            'vtex.environment' => 'vtexcommercestable'
        ]);

        $this->brandService = new BrandService(
            'test-app-key',
            'test-app-token'
        );
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        // Configuración necesaria para las pruebas
        $app['config']->set('vtex.app_key', 'test-app-key');
        $app['config']->set('vtex.app_token', 'test-app-token');
        $app['config']->set('vtex.account_name', 'test-store');
        $app['config']->set('vtex.environment', 'vtexcommercestable');
    }

    public function test_get_brand_list_returns_collection_of_brand_data(): void
    {
        // Arrange
        $mockResponse = [
            [
                'id' => 1,
                'name' => 'Brand 1',
                'isActive' => true,
                'metaTagDescription' => 'Brand 1 Description',
                'imageUrl' => null,
                'title' => 'Brand 1 Title'
            ],
            [
                'id' => 2,
                'name' => 'Brand 2',
                'isActive' => false,
                'metaTagDescription' => 'Brand 2 Description',
                'imageUrl' => null,
                'title' => 'Brand 2 Title'
            ],
        ];

        Http::fake([
            '*' => Http::response($mockResponse, 200)
        ]);

        // Act
        $result = $this->brandService->getBrandList();

        // Assert
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(BrandListData::class, $result->first());
        $this->assertEquals(1, $result->first()->id);
        $this->assertEquals('Brand 1', $result->first()->name);
        $this->assertTrue($result->first()->isActive);
        $this->assertEquals('Brand 1 Description', $result->first()->metaTagDescription);
    }

    public function test_get_brand_list_per_page_returns_paginated_results(): void
    {
        // Arrange
        $mockResponse = [
            'items' => [
                [
                    'id' => 1,
                    'name' => 'Brand 1',
                    'isActive' => true,
                    'metaTagDescription' => 'Brand 1 Description',
                    'imageUrl' => null,
                    'title' => 'Brand 1 Title'
                ],
            ],
            'paging' => [
                'page' => 1,
                'perPage' => 1,
                'total' => 1,
                'pages' => 1
            ],
        ];

        Http::fake([
            '*' => Http::response($mockResponse, 200)
        ]);

        // Act
        $result = $this->brandService->getBrandListPerPage(1, 1);

        // Assert
        $this->assertInstanceOf(BrandPaginatedListData::class, $result);
        $this->assertInstanceOf(BrandListData::class, $result->items[0]);
        $this->assertInstanceOf(BrandPagingData::class, $result->paging);
        $this->assertEquals(1, $result->items[0]->id);
        $this->assertEquals('Brand 1', $result->items[0]->name);
        $this->assertTrue($result->items[0]->isActive);
        $this->assertEquals('Brand 1 Description', $result->items[0]->metaTagDescription);
        $this->assertEquals(1, $result->paging->page);
        $this->assertEquals(1, $result->paging->perPage);
        $this->assertEquals(1, $result->paging->total);
        $this->assertEquals(1, $result->paging->pages);
    }

    public function test_get_brand_returns_single_brand_data(): void
    {
        // Arrange
        $mockResponse = [
            'id' => 1,
            'name' => 'Brand 1',
            'isActive' => true,
            'metaTagDescription' => 'Brand 1 Description',
            'imageUrl' => null,
            'title' => 'Brand 1 Title'
        ];

        Http::fake([
            '*' => Http::response($mockResponse, 200)
        ]);

        // Act
        $result = $this->brandService->getBrand(1);

        // Assert
        $this->assertInstanceOf(BrandListData::class, $result);
        $this->assertEquals(1, $result->id);
        $this->assertEquals('Brand 1', $result->name);
        $this->assertTrue($result->isActive);
        $this->assertEquals('Brand 1 Description', $result->metaTagDescription);
    }

    public function test_get_brand_and_context_returns_array(): void
    {
        // Arrange
        $mockResponse = [
            'brand' => [
                'Id' => 1,
                'Name' => 'Brand 1',
            ],
            'context' => [
                'some' => 'data',
            ],
        ];

        Http::fake([
            '*' => Http::response($mockResponse, 200)
        ]);

        // Act
        $result = $this->brandService->getBrandAndContext(1);

        // Assert
        $this->assertIsArray($result);
        $this->assertArrayHasKey('brand', $result);
        $this->assertArrayHasKey('context', $result);
    }

    public function test_create_brand_returns_brand_data(): void
    {
        // Arrange
        $mockResponse = [
            'Id' => 1,
            'Name' => 'New Brand',
            'Text' => 'New Brand Description',
            'Keywords' => 'new brand',
            'SiteTitle' => 'New Brand Title',
            'Active' => true,
            'MenuHome' => true,
            'AdWordsRemarketingCode' => '',
            'LomadeeCampaignCode' => '',
            'Score' => null,
            'LinkId' => 'new-brand'
        ];

        Http::fake([
            '*' => Http::response($mockResponse, 200)
        ]);

        $brandData = [
            'Name' => 'New Brand',
            'Text' => 'New Brand Description',
            'Keywords' => 'new brand',
            'SiteTitle' => 'New Brand Title',
            'Active' => true,
            'MenuHome' => true
        ];

        // Act
        $result = $this->brandService->createBrand($brandData);

        // Assert
        $this->assertInstanceOf(BrandCreateData::class, $result);
        $this->assertEquals(1, $result->id);
        $this->assertEquals('New Brand', $result->name);
        $this->assertTrue($result->active);
        $this->assertEquals('New Brand Description', $result->text);
    }

    public function test_update_brand_returns_brand_data(): void
    {
        // Arrange
        $mockResponse = [
            'Id' => 1,
            'Name' => 'Updated Brand',
            'Text' => 'Updated Brand Description',
            'Keywords' => 'updated brand',
            'SiteTitle' => 'Updated Brand Title',
            'Active' => true,
            'MenuHome' => true,
            'AdWordsRemarketingCode' => '',
            'LomadeeCampaignCode' => '',
            'Score' => null,
            'LinkId' => 'updated-brand'
        ];

        Http::fake([
            '*' => Http::response($mockResponse, 200)
        ]);

        $brandData = [
            'Name' => 'Updated Brand',
            'Text' => 'Updated Brand Description',
            'Keywords' => 'updated brand',
            'SiteTitle' => 'Updated Brand Title',
            'Active' => true,
            'MenuHome' => true
        ];

        // Act
        $result = $this->brandService->updateBrand(1, $brandData);

        // Assert
        $this->assertInstanceOf(BrandCreateData::class, $result);
        $this->assertEquals(1, $result->id);
        $this->assertEquals('Updated Brand', $result->name);
        $this->assertTrue($result->active);
        $this->assertEquals('Updated Brand Description', $result->text);
    }

    public function test_delete_brand_returns_void(): void
    {
        // Arrange
        Http::fake([
            '*' => Http::response(null, 204)
        ]);

        // Act & Assert
        $this->brandService->deleteBrand(1);
        $this->assertTrue(true); // If we got here, no exception was thrown
    }

    public function test_get_brand_list_with_error_response(): void
    {
        // Arrange
        Http::fake([
            '*' => Http::response(['message' => 'Server Error'], 500)
        ]);

        // Assert
        $this->expectException(\Throwable::class);

        // Act
        $this->brandService->getBrandList();
    }

    public function test_create_brand_with_invalid_data(): void
    {
        // Arrange
        Http::fake([
            '*' => Http::response(['message' => 'Invalid data'], 400)
        ]);

        // Assert
        $this->expectException(\Throwable::class);

        // Act
        $this->brandService->createBrand([]);
    }
}
