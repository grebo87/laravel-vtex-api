<?php

namespace Tests\Unit\Services\Catalog;

use Grebo87\LaravelVtexApi\Data\Catalog\Categories\CategoryData;
use Grebo87\LaravelVtexApi\Data\Catalog\Categories\CategoryTreeData;
use Grebo87\LaravelVtexApi\Services\Catalog\CategoryService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use Grebo87\LaravelVtexApi\Providers\LaravelVtexApiServiceProvider;
use Orchestra\Testbench\TestCase;

class CategoryServiceTest extends TestCase
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

    private CategoryService $categoryService;

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

        $this->categoryService = new CategoryService();
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

    public function test_get_category_tree_returns_collection_of_category_tree_data(): void
    {
        // Arrange
        $mockResponse = [
            [
                'id' => 1,
                'name' => 'Category 1',
                'hasChildren' => true,
                'url' => 'https://test-store.vtexcommercestable.com.br/category-1',
                'children' => [
                    [
                        'id' => 2,
                        'name' => 'Subcategory 1',
                        'hasChildren' => false,
                        'url' => 'https://test-store.vtexcommercestable.com.br/category-1/subcategory-1',
                        'children' => [],
                        'Title' => 'Subcategory 1 Title',
                        'MetaTagDescription' => 'Subcategory 1 Description'
                    ]
                ],
                'Title' => 'Category 1 Title',
                'MetaTagDescription' => 'Category 1 Description'
            ]
        ];

        Http::fake([
            '*' => Http::response($mockResponse, 200)
        ]);

        // Act
        $result = $this->categoryService->getCategoryTree();

        // Assert
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(CategoryTreeData::class, $result->first());
        $this->assertEquals(1, $result->first()->id);
        $this->assertEquals('Category 1', $result->first()->name);
        $this->assertTrue($result->first()->hasChildren);
        $this->assertCount(1, $result->first()->children);
    }

    public function test_get_category_returns_category_data(): void
    {
        // Arrange
        $mockResponse = [
            'Id' => 1,
            'Name' => 'Home Appliances',
            'FatherCategoryId' => null,
            'Title' => 'Home Appliances',
            'Description' => 'Home Appliances Description',
            'Keywords' => 'appliances, home',
            'IsActive' => true,
            'LomadeeCampaignCode' => '',
            'AdWordsRemarketingCode' => '',
            'ShowInStoreFront' => true,
            'ShowBrandFilter' => true,
            'ActiveStoreFrontLink' => true,
            'GlobalCategoryId' => 3367,
            'StockKeepingUnitSelectionMode' => 'LIST',
            'Score' => null,
            'LinkId' => 'home-appliances',
            'HasChildren' => true
        ];

        Http::fake([
            '*' => Http::response($mockResponse, 200)
        ]);

        // Act
        $result = $this->categoryService->getCategory(1);

        // Assert
        $this->assertInstanceOf(CategoryData::class, $result);
        $this->assertEquals(1, $result->Id);
        $this->assertEquals('Home Appliances', $result->Name);
        $this->assertTrue($result->IsActive);
        $this->assertEquals('Home Appliances', $result->Title);
        $this->assertEquals('Home Appliances Description', $result->Description);
    }

    public function test_create_category_returns_category_data(): void
    {
        // Arrange
        $mockResponse = [
            'Id' => 1,
            'Name' => 'New Category',
            'FatherCategoryId' => null,
            'Title' => 'New Category',
            'Description' => 'New Category Description',
            'Keywords' => 'new, category',
            'IsActive' => true,
            'LomadeeCampaignCode' => '',
            'AdWordsRemarketingCode' => '',
            'ShowInStoreFront' => true,
            'ShowBrandFilter' => true,
            'ActiveStoreFrontLink' => true,
            'GlobalCategoryId' => 800,
            'StockKeepingUnitSelectionMode' => 'SPECIFICATION',
            'Score' => null,
            'LinkId' => 'new-category',
            'HasChildren' => false
        ];

        Http::fake([
            '*' => Http::response($mockResponse, 200)
        ]);

        $categoryData = new CategoryData(
            Name: 'New Category',
            Title: 'New Category',
            Description: 'New Category Description',
            Keywords: 'new, category',
            GlobalCategoryId: 800
        );

        // Act
        $result = $this->categoryService->createCategory($categoryData);

        // Assert
        $this->assertInstanceOf(CategoryData::class, $result);
        $this->assertEquals(1, $result->Id);
        $this->assertEquals('New Category', $result->Name);
        $this->assertTrue($result->IsActive);
        $this->assertEquals('New Category', $result->Title);
        $this->assertEquals('New Category Description', $result->Description);
    }

    public function test_update_category_returns_category_data(): void
    {
        // Arrange
        $mockResponse = [
            'Id' => 1,
            'Name' => 'Updated Category',
            'FatherCategoryId' => null,
            'Title' => 'Updated Category',
            'Description' => 'Updated Category Description',
            'Keywords' => 'updated, category',
            'IsActive' => true,
            'LomadeeCampaignCode' => '',
            'AdWordsRemarketingCode' => '',
            'ShowInStoreFront' => true,
            'ShowBrandFilter' => true,
            'ActiveStoreFrontLink' => true,
            'GlobalCategoryId' => 800,
            'StockKeepingUnitSelectionMode' => 'SPECIFICATION',
            'Score' => null,
            'LinkId' => 'updated-category',
            'HasChildren' => false
        ];

        Http::fake([
            '*' => Http::response($mockResponse, 200)
        ]);

        $categoryData = new CategoryData(
            Name: 'Updated Category',
            Title: 'Updated Category',
            Description: 'Updated Category Description',
            Keywords: 'updated, category',
            GlobalCategoryId: 800
        );

        // Act
        $result = $this->categoryService->updateCategory(1, $categoryData);

        // Assert
        $this->assertInstanceOf(CategoryData::class, $result);
        $this->assertEquals(1, $result->Id);
        $this->assertEquals('Updated Category', $result->Name);
        $this->assertTrue($result->IsActive);
        $this->assertEquals('Updated Category', $result->Title);
        $this->assertEquals('Updated Category Description', $result->Description);
    }
}
