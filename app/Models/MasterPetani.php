<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPetani extends Model
{
    use HasFactory;

    protected $fillable = ['nama_petani', 'no_hp', 'alamat'];
}
