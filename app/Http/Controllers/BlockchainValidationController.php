<?php

namespace App\Http\Controllers;

use App\Models\Block;
use App\Services\BlockchainService;
use Illuminate\Http\Request;

class BlockchainValidationController extends Controller
{
    public function index()
    {
        // Gunakan method yang sama dari BlockchainService
        $validation = BlockchainService::getValidationResults();
        
        return view('admin.blockchain.validate', $validation);
    }
    
    private function validateChain($blocks)
    {
        // Redirect ke BlockchainService untuk konsistensi
        return BlockchainService::validateChain($blocks);
    }
    
    public function recalculate()
    {
        $blocks = Block::orderBy('id')->get();
        $fixed = 0;
        
        foreach ($blocks as $index => $block) {
            $previousHash = $index === 0 ? '0' : $blocks[$index - 1]->hash;
            
            $dataString = json_encode([
                'stok_id' => $block->stok_id,
                'action' => $block->action,
                'data' => $block->data,
                'previous_hash' => $previousHash,
                'timestamp' => $block->timestamp
            ]);
            
            $newHash = hash('sha256', $dataString);
            
            if ($block->hash !== $newHash || $block->previous_hash !== $previousHash) {
                $block->update([
                    'previous_hash' => $previousHash,
                    'hash' => $newHash,
                    'is_valid' => 1
                ]);
                $fixed++;
            }
        }
        
        return redirect()->route('blockchain.validate')
            ->with('success', "Blockchain berhasil diperbaiki! {$fixed} block telah diupdate.");
    }
}
