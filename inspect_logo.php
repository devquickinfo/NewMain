<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$school = App\Models\School::latest()->first();

if ($school) {
    echo $school->logo . PHP_EOL;
    if ($school->logo && file_exists(storage_path('app/public/' . $school->logo))) {
        echo 'exists in storage' . PHP_EOL;
    } else {
        echo 'missing from storage' . PHP_EOL;
    }
}
