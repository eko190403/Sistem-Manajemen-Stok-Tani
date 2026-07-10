<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\MasterPetani;
use App\Services\ActivityLogService;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

try {
    $user = User::where('role', 'admin')->first();
    Auth::login($user);

    $petani = MasterPetani::create([
        'nama_petani' => 'Testing Petani',
        'no_hp' => '0812',
        'alamat' => 'Alamat test'
    ]);
    
    ActivityLogService::log('create', "Menambah master petani: {$petani->nama_petani}", 'MasterPetani', $petani->id);
    
    echo "SUCCESS\n";
} catch (\Exception $e) {
    echo "EXCEPTION: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
