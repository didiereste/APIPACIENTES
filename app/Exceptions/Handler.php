<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /* Manneja la respuesta JSON al no haber encontrado el id de nuestro caso el paciente */

    public function render($request, Throwable $exception)
    {
        if($exception instanceof ModelNotFoundException){
            return response()->json(["res" => false, "error" => "Error dato no encontrado"], 400);
        }


        //manejar la respuesta json en caso de que el usuario no tenga token y quiera acceder a rutas que exigen tener token

        if($exception instanceof RouteNotFoundException){
            return response()->json(["res" => false, "error" => "No tiene permisos para acceder a esta ruta"], 401);
        }
        return parent::render($request, $exception);
    }
}
