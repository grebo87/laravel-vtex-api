# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.1.0] - 2024-02-25

### Added

- Integration with VTEX Categories API
- Implementation of DTOs for categories:
  - `CategoryData`: For handling category data
  - `CategoryTreeData`: For handling category tree structure
- Implementation of `CategoryService` with methods for:
  - Get category tree
  - Get category by ID
  - Create category
  - Update category
- `Category` facade for simplified service access
- Implementation of unit tests for category service

- Integration with VTEX Category Specifications API
- Implementation of `CategorySpecificationData` DTO for handling category specifications
- Implementation of `CategorySpecificationService` with methods for:
  - Get specifications by category ID
  - Get specifications tree by category ID
- Implementation of unit tests for specifications service
- `CategorySpecification` facade for simplified service access

## [1.0.0] - 2024-02-24

### Added

- Initial integration with VTEX Brands API
- Implementation of DTOs for brands:
  - `BrandListData`: For listing brands
  - `BrandCreateData`: For creating brands
  - `BrandPaginatedListData`: For paginated brand listing
  - `BrandPagingData`: For handling pagination
- Implementation of `BrandService` with methods for:
  - Get brand list
  - Get brand by ID
  - Create brand
  - Update brand
  - Delete brand
- Implementation of unit tests for all components
- GitHub Actions setup for automated testing
- Complete documentation with usage examples

### Features

- Support for Laravel 9.x, 10.x and 11.x
- Support for PHP 8.3+
- Data validation with DTOs
- Robust error handling
- Strict typing for better safety
- English documentation
