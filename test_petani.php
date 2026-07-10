<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

// Login as admin
$user = App\Models\User::where('role', 'admin')->first();
auth()->login($user);

$request = Illuminate\Http\Request::create('/dashboard/master-petani', 'POST', [
    'nama_petani' => 'Test Petani From Script',
    'no_hp' => '08123456',
    'alamat' => 'Alamat test'
]);

$response = $kernel->handle($request);
echo "Status: " . $response->getStatusCode() . "\n";
echo "Content: " . $response->getContent() . "\n";
