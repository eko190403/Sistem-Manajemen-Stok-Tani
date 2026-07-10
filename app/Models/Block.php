<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = [
        'stok_id',
        'action',
        'data',
        'actor',
        'previous_hash',
        'hash',
    ];

    public function calculateHash()
    {
        $data = json_decode($this->data, true);
        return \App\Services\BlockchainService::generateHash(
            $data, 
            $this->previous_hash, 
            $this->action
        );
    }


}
