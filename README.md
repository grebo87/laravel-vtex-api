#  Laravel VTEX API

Provides a seamless integration between Laravel and the VTEX API.

## Installation

Use the composer to install the package.

```bash
composer require grebo87/laravel-vtex-api
```

## Usage
Use package classes or facades

### Class

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Grebo87\LaravelVtexApi\Api\Catalog\Category;

class SomeControler extends Controller
{
    public function index()
    {
    	return (new Category)->getCategoryTree();
        //or
       $category = new Category;
       return $category->getCategoryTree();
    }
}
```

### Facade

```php
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Grebo87\LaravelVtexApi\Facades\Category;

class SomeControler extends Controller
{
    public function index()
    {
    	return Category::getCategoryTree();
    }
}
```

## Contributing

Pull requests are welcome. For major changes, please open an issue first
to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License

[MIT](LICENSE.md)
