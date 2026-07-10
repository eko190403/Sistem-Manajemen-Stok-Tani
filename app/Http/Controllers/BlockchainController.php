<?php

namespace App\Http\Controllers;

use App\Models\Block;

class BlockchainController extends Controller
{
    public function index()
    {
        $blocks = Block::orderBy('id')->get();
        return view('blockchain.index', compact('blocks'));
    }

    public function destroy($id)
    {
        return back()->with('error', 'Dalam arsitektur Blockchain, blok tidak boleh dihapus untuk menjaga integritas data.');
    }

    public function validateChain()
    {
        $blocks = Block::orderBy('id')->get();
        $isValid = true;
        $errorMessage = null;

        foreach ($blocks as $i => $block) {
            // 1. Validasi hash isi
            if ($block->hash !== $block->calculateHash()) {
                $isValid = false;
                $errorMessage = "Hash blok ID {$block->id} tidak valid";
                break;
            }

            // 2. Genesis block
            if ($i === 0) {
                if ($block->previous_hash !== '0') {
                    $isValid = false;
                    $errorMessage = "Genesis block rusak";
                    break;
                }
            } else {
                $prev = $blocks[$i - 1];
                if ($block->previous_hash !== $prev->hash) {
                    $isValid = false;
                    $errorMessage = "Previous hash blok ID {$block->id} tidak cocok";
                    break;
                }
            }
        }

        return view('blocks.validate', compact('blocks', 'isValid', 'errorMessage'));
    }
}
