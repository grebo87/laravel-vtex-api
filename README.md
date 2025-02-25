# Laravel VTEX API

Un paquete de Laravel que proporciona una integración fluida con la API de VTEX.

## Versiones y Compatibilidad

| Rama | Versión | Compatibilidad Laravel | PHP | Estado |
|--------|----------|---------------------|-----|---------|
| main   | dev      | última versión      | ^8.3 | Desarrollo |
| 1.x    | 1.0.0    | 9.x, 10.x, 11.x    | ^8.3 | Estable |

### Matriz de Compatibilidad

| Laravel | PHP Compatible | Estado |
|---------|----------------|---------|
| 9.x     | 8.3           | ✅ Soportado |
| 10.x    | 8.3           | ✅ Soportado |
| 11.x    | 8.3           | ✅ Soportado |

### Pruebas Automatizadas

Este paquete se prueba automáticamente en todas las versiones soportadas usando GitHub Actions.
Puedes verificar el estado de las pruebas en la pestaña "Actions" del repositorio.

### Compatibilidad con Laravel

Este paquete está diseñado para ser compatible con múltiples versiones de Laravel:

- Laravel 9.x
- Laravel 10.x
- Laravel 11.x

Utilizamos una estrategia de compatibilidad hacia adelante, lo que significa que el paquete se mantiene actualizado con las últimas versiones de Laravel mientras mantiene la compatibilidad con versiones anteriores cuando es posible.

### Estado de Soporte de Ramas

- **Rama 1.x (Actual)**
  - Compatible con Laravel 9.x, 10.x, 11.x
  - PHP 8.3+
  - Características actuales:
    * API de Marcas (Brands)
    * DTOs y validación

- **Rama main (Desarrollo)**
  - Última versión en desarrollo
  - Mejoras continuas y nuevas características
  - Actualizaciones de pruebas y documentación

## Compatibilidad de Versiones

| Laravel VTEX API | PHP | Laravel | Estado |
|-----------------|-----|----------|---------|
| 1.0.0          | ^8.3 | ^9.0\|^10.0\|^11.0 | Estable |

## Requisitos

- PHP ^8.3
- Laravel ^9.0|^10.0|^11.0
- Composer 2.x

## Instalación

Puedes instalar el paquete vía composer. El paquete registrará automáticamente su proveedor de servicios y fachadas.

```bash
composer require grebo87/laravel-vtex-api
```

Esto instalará la última versión estable (1.0.0) del paquete.

## Contribuir

### Flujo de Desarrollo

1. Haz un fork del repositorio
2. Crea una rama de característica desde `1.x`:
```bash
git checkout 1.x
git checkout -b feature/mi-nueva-caracteristica
```
3. Realiza tus cambios y haz commit usando mensajes semánticos:
```bash
git commit -m "feat: agregar integración de API de productos"
```
4. Haz push a tu fork y envía un pull request a la rama `1.x`

### Estrategia de Ramas

- `main`: Código listo para producción
- `1.x`: Rama de desarrollo para la versión 1
- `feature/*`: Nuevas características
- `bugfix/*`: Correcciones de errores
- `release/*`: Preparación de releases

## Configuración

1. Publica el archivo de configuración:

```bash
php artisan vendor:publish --provider="Grebo87\LaravelVtexApi\Providers\LaravelVtexApiServiceProvider"
```

2. Agrega las siguientes variables a tu archivo .env:

```env
VTEX_APP_TOKEN=your-app-token
VTEX_APP_KEY=your-app-key
VTEX_ACCOUNT_NAME=your-account-name
VTEX_ENVIROMENT=your-environment
```

## Uso

### Gestión de Marcas

```php
<?php

namespace App\Http\Controllers;

use Grebo87\LaravelVtexApi\Services\Catalog\BrandService;
use Grebo87\LaravelVtexApi\Data\Catalog\Brands\BrandCreateData;

class BrandController extends Controller
{
    private BrandService $brandService;

    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function index()
    {
        // Obtener lista de marcas
        return $this->brandService->getBrandList();
    }

    public function show(int $id)
    {
        // Obtener marca por ID
        return $this->brandService->getBrand($id);
    }

    public function store(array $data)
    {
        // Crear una nueva marca usando DTO
        $brandData = new BrandCreateData(
            name: $data['name'],
            text: $data['text'] ?? null,
            keywords: $data['keywords'] ?? [],
            siteTitle: $data['siteTitle'] ?? null,
            active: $data['active'] ?? true,
            menuHome: $data['menuHome'] ?? false,
            score: $data['score'] ?? null
        );

        // Usar el DTO con el servicio
        return $this->brandService->createBrand($brandData);
    }
}
```

### Usando Facades

```php
<?php

namespace App\Http\Controllers;

use Grebo87\LaravelVtexApi\Facades\Brand;

class BrandController extends Controller
{
    public function index()
    {
        // Obtener lista de marcas
        return Brand::getBrandList();
    }

    public function show(int $id)
    {
        // Obtener marca por ID
        return Brand::getBrand($id);
    }
}
```

## Contribuciones

Los pull requests son bienvenidos. Para cambios importantes, por favor abre primero un issue
para discutir lo que te gustaría cambiar.

Asegúrate de actualizar las pruebas según corresponda.

## Licencia

[MIT](LICENSE.md)
