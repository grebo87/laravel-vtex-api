# Changelog

Todos los cambios notables en este proyecto serán documentados en este archivo.

El formato está basado en [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
y este proyecto se adhiere a [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2024-02-24

### Agregado

- Integración inicial con la API de Marcas (Brands) de VTEX
- Implementación de DTOs para marcas:
  - `BrandListData`: Para listar marcas
  - `BrandCreateData`: Para crear marcas
  - `BrandPaginatedListData`: Para listar marcas con paginación
  - `BrandPagingData`: Para manejar la paginación
- Implementación del servicio `BrandService` con métodos para:
  - Obtener lista de marcas
  - Obtener marca por ID
  - Crear marca
  - Actualizar marca
  - Eliminar marca
- Implementación de pruebas unitarias para todos los componentes
- Configuración de GitHub Actions para pruebas automatizadas
- Documentación completa con ejemplos de uso

### Características

- Soporte para Laravel 9.x, 10.x y 11.x
- Soporte para PHP 8.3+
- Validación de datos con DTOs
- Manejo de errores robusto
- Tipado estricto para mayor seguridad
- Documentación en español
