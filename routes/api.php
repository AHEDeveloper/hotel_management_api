<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1/admin')->group(function () {

    require __DIR__ . '/admin_V1.php';

});

