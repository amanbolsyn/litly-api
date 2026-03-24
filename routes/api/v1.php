<?php

use App\Http\Controllers\Api\v1\AuthorController;
use App\Http\Controllers\Api\v1\RegisterController;
use App\Http\Controllers\Api\v1\DashboardController;
use App\Http\Controllers\Api\v1\CartController;
use App\Http\Controllers\Api\v1\CategoryController;
use App\Http\Controllers\Api\v1\RoleController;
use App\Http\Controllers\Api\V1\SessionController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\BookController;
use App\Http\Controllers\Api\v1\CollectionController;
use App\Http\Controllers\Api\v1\OrganizationController;
use App\Http\Controllers\Api\v1\PublisherController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {

    Route::controller(RegisterController::class)
        ->group(function () {
            Route::post('/register', 'store');
            Route::get('/auth/verify-email/{id}/{hash}', 'verifyEmail')->name('verification.verify');
            Route::post('/auth/resend-verification', 'sendVerificaton');
        });

    Route::controller(SessionController::class)
        ->group(function () {
            Route::post('/login', 'store');
            Route::middleware("auth:sanctum")->post('/logout', 'destroy');
        });

    Route::controller(UserController::class)
        ->middleware(['auth:sanctum'])
        ->prefix("users")
        ->group(function () {
            Route::get("/", 'index')->name('user.index');
            Route::get("/{user}", 'show')->name('user.show');
            Route::put("/{user}", 'update');
            Route::get("/collections", "getUserCollections");
        });


    Route::controller(CartController::class)
        ->middleware(['auth:sanctum'])
        ->prefix("carts")
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/{cart}', 'show');
            Route::post('/', 'store');
            Route::put('/{cart}', 'update');
        });


    Route::controller(BookController::class)
        ->prefix("books")
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/{book}', 'show');

            Route::middleware(['auth:sanctum'])
                ->group(function () {
                    Route::post('/', 'store');
                    Route::put('/{book}', 'update');
                    Route::delete('/{book}', 'destroy');
                });
        });


    Route::controller(CollectionController::class)
        ->prefix("collections")
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/{collection}', 'show');

            Route::middleware(["auth:sanctum"])
                ->group(function () {
                    Route::post('/', 'store');
                    Route::put('/{collection}', 'update');
                    Route::delete('/{collection}', 'destroy');
                });
        });

    Route::controller(CategoryController::class)
        ->prefix("categories")
        ->group(function () {
            Route::get('/', 'index');

            Route::middleware(["auth:sanctum"])->group(function () {
                Route::post('/', 'store');
                Route::put('/{category}', 'update');
                Route::delete('/{category}', 'destroy');
            });
        });


    Route::controller(AuthorController::class)
        ->prefix("authors")
        ->group(function () {
            Route::get('/', 'index')->name('author.index');
            Route::get('/{author}', 'show')->name('author.show');

            Route::middleware(["auth:sanctum"])->group(function () {
                Route::post('/', 'store')->name('author.store');
                Route::put('/{author}', 'update')->name('author.update');;
                Route::delete('/{author}', 'destroy');
            });
        });

    Route::controller(OrganizationController::class)
        ->prefix("organizations")
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/', 'show');

            Route::middleware(["auth:sanctum"])->group(function () {
                Route::post('/', 'store');
                Route::put('/{organization}', 'update');
                Route::delete('/{organization}', 'destroy');
                Route::get("{organization}/carts", 'getOrganizationCarts');
                Route::get("{organization}/roles", 'getOrganizationRoles');
            });
        });


    Route::controller(PublisherController::class)
        ->prefix("publishers")
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/{publisher}', 'show');

            Route::middleware(['auth:sanctum'])
                ->group(function () {
                    Route::post('/', 'store');
                    Route::put('/{publisher}', 'update');
                    Route::delete('/{publisher}', 'destroy');
                });
        });


    Route::controller(DashboardController::class)
        ->middleware(['auth:sanctum'])
        ->group(function () {
            Route::get('/dashboard', 'index');
        });

    Route::controller(RoleController::class)
        ->middleware(['auth:sanctum'])
        ->group(function () {
            Route::get('/roles', 'index');
        });
});
