<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TenantController;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        Route::get('/', function () {
            abort(404);
        });
    });
}
