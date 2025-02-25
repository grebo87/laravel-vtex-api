<?php

namespace Grebo87\LaravelVtexApi\Tests\Services\Catalog;

use Grebo87\LaravelVtexApi\Services\Catalog\CategorySpecificationService;
use Grebo87\LaravelVtexApi\Tests\TestCase;
use Illuminate\Support\Collection;

class CategorySpecificationServiceTest extends TestCase
{
    private CategorySpecificationService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new CategorySpecificationService();
    }

    /** @test */
    public function it_can_get_specifications_by_category_id(): void
    {
        // Arrange
        $categoryId = 1;
        $expectedResponse = [
            [
                'Name' => 'Specification A',
                'CategoryId' => 1,
                'FieldId' => 33,
                'IsActive' => true,
                'IsStockKeepingUnit' => false
            ]
        ];

        $this->mockResponse($expectedResponse);

        // Act
        $result = $this->service->getSpecifications($categoryId);

        // Assert
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);
        $specification = $result->first();
        $this->assertEquals('Specification A', $specification->Name);
        $this->assertEquals(1, $specification->CategoryId);
        $this->assertEquals(33, $specification->FieldId);
        $this->assertTrue($specification->IsActive);
        $this->assertFalse($specification->IsStockKeepingUnit);
    }

    /** @test */
    public function it_can_get_specifications_tree_by_category_id(): void
    {
        // Arrange
        $categoryId = 1;
        $expectedResponse = [
            [
                'Name' => 'Specification A',
                'CategoryId' => 1,
                'FieldId' => 33,
                'IsActive' => true,
                'IsStockKeepingUnit' => false
            ]
        ];

        $this->mockResponse($expectedResponse);

        // Act
        $result = $this->service->getSpecificationsTree($categoryId);

        // Assert
        $this->assertInstanceOf(Collection::class, $result);
        $this->assertCount(1, $result);
        $specification = $result->first();
        $this->assertEquals('Specification A', $specification->Name);
        $this->assertEquals(1, $specification->CategoryId);
        $this->assertEquals(33, $specification->FieldId);
        $this->assertTrue($specification->IsActive);
        $this->assertFalse($specification->IsStockKeepingUnit);
    }
}
