<?php

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        apiPrefix: 'api/v1'
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // Ruta no encontrada.
        $exceptions->render(function (RouteNotFoundException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => 'No autenticado. La sesión es inválida o ha expirado.'
                ], 401);
            }
        });

        // 422
        $exceptions->render(function (ValidationException $e, $request) {
            return response()->json([
                'error' => 'Error de validación',
                'details' => $e->errors()
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        });

        // 401
        $exceptions->render(function (AuthenticationException $e, $request) {
            return response()->json([
                'error' => 'No autenticado, porfavor inicie sesión de nuevo.'
            ], Response::HTTP_UNAUTHORIZED);
        });

        // 403
        $exceptions->render(function (AuthorizationException $e, $request) {
            return response()->json([
                'error' => 'No autorizado.'
            ], Response::HTTP_FORBIDDEN);
        });

        // Modelo no encontrado
        $exceptions->render(function (ModelNotFoundException $e, $request) {
            return response()->json([
                'error' => 'Modelo no encontrado.'
            ], Response::HTTP_NOT_FOUND);
        });

        $exceptions->render(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'error' => 'Ruta o recurso no encontrado.'
            ], Response::HTTP_NOT_FOUND);
        });

        $exceptions->render(function (QueryException $e, $request) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Error interno.'
            ], 500);
        });

        $exceptions->render(function (UnauthorizedHttpException $e, $request) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Hubo un problema, por favor, inicie sesión de nuevo.'
            ], 401);
        });

        $exceptions->render(function (\Throwable $e, $request) {
            Log::error($e->getMessage());
            return response()->json([
                'error' => 'Error interno.'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        });
    })->create();
