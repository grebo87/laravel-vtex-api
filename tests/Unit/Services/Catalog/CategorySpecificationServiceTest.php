<?php

namespace Tests\Unit\Services\Catalog;

use Grebo87\LaravelVtexApi\Data\Catalog\Categories\CategorySpecificationData;
use Grebo87\LaravelVtexApi\Services\Catalog\CategorySpecificationService;
use Grebo87\LaravelVtexApi\Providers\LaravelVtexApiServiceProvider;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase;

class CategorySpecificationServiceTest extends TestCase
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

    private CategorySpecificationService $categorySpecificationService;

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

        $this->categorySpecificationService = new CategorySpecificationService();
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

    public function test_get_specifications_returns_collection_of_specification_data(): void
    {
        // Arrange
        $categoryId = 1;
        $mockResponse = [
            [
                'Name' => 'Specification A',
                'CategoryId' => 1,
                'FieldId' => 33,
                'IsActive' => true,
                'IsStockKeepingUnit' => false
            ],
            [
                'Name' => 'Specification B',
                'CategoryId' => 1,
                'FieldId' => 34,
                'IsActive' => true,
                'IsStockKeepingUnit' => false
            ]
        ];

        Http::fake([
            '*' => Http::response($mockResponse, 200)
        ]);

        // Act
        $result = $this->categorySpecificationService->getSpecifications($categoryId);

        // Assert
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(CategorySpecificationData::class, $result->first());
        $this->assertEquals('Specification A', $result->first()->Name);
        $this->assertEquals(1, $result->first()->CategoryId);
        $this->assertEquals(33, $result->first()->FieldId);
        $this->assertTrue($result->first()->IsActive);
        $this->assertFalse($result->first()->IsStockKeepingUnit);
    }

    public function test_get_specifications_tree_returns_collection_of_specification_data(): void
    {
        // Arrange
        $categoryId = 1;
        $mockResponse = [
            [
                'Name' => 'Specification A',
                'CategoryId' => 1,
                'FieldId' => 33,
                'IsActive' => true,
                'IsStockKeepingUnit' => false
            ],
            [
                'Name' => 'Specification B',
                'CategoryId' => 1,
                'FieldId' => 34,
                'IsActive' => true,
                'IsStockKeepingUnit' => false
            ]
        ];

        Http::fake([
            '*' => Http::response($mockResponse, 200)
        ]);

        // Act
        $result = $this->categorySpecificationService->getSpecificationsTree($categoryId);

        // Assert
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(2, $result);
        $this->assertInstanceOf(CategorySpecificationData::class, $result->first());
        $this->assertEquals('Specification A', $result->first()->Name);
        $this->assertEquals(1, $result->first()->CategoryId);
        $this->assertEquals(33, $result->first()->FieldId);
        $this->assertTrue($result->first()->IsActive);
        $this->assertFalse($result->first()->IsStockKeepingUnit);
    }
}
