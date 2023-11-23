<?php

namespace Grebo87\LaravelVtexApi\Exceptions;

use Illuminate\Validation\ValidationException;

class CustomValidationException extends ValidationException
{
    public function render($request)
    {
        // Puedes personalizar la forma en que la excepción se renderiza
        // Por ejemplo, puedes devolver una respuesta JSON personalizada
        return response()->json([
            'message' => 'Validation Vtex failed',
            'errors' => $this->errors(),
        ], 422);
    }
}
