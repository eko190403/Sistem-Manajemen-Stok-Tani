<?php

namespace App\Services;

use App\Models\Block;

class BlockchainService
{
    /**
     * Recursively sort array keys so JSON encoding is deterministic.
     */
    public static function recursiveKsort(&$arr): void
    {
        if (!is_array($arr)) {
            return;
        }
        ksort($arr);
        foreach ($arr as &$v) {
            if (is_array($v)) {
                self::recursiveKsort($v);
            }
        }
    }

    /**
     * Convert data (array or JSON string) into canonical JSON string.
     */
    public static function canonicalJson($data): string
    {
        if (is_string($data)) {
            $decoded = json_decode($data, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data = $decoded;
            } else {
                // not valid JSON, return as string
                return (string) $data;
            }
        }

        if (!is_array($data)) {
            // scalar value
            return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        // sort keys recursively
        self::recursiveKsort($data);

        // encode deterministically
        return json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    /**
     * Generate hash for a block.
     * NOTE: createdAt is NOT used to avoid timing mismatch issues.
     */
    public static function generateHash($data, ?string $previousHash, string $action): string
    {
        $canonical = self::canonicalJson($data);

        // fixed order: previousHash | action | canonicalData
        $payload = ($previousHash ?? '0') . '|' . $action . '|' . $canonical;

        return hash('sha256', $payload);
    }

    /**
     * Add block into blockchain table.
     */
    public static function addBlock(?int $stokId, string $action, $data): void
    {
        $previousBlock = Block::latest()->first();
        $previousHash  = $previousBlock ? $previousBlock->hash : null;

        $hash = self::generateHash($data, $previousHash, $action);

        Block::create([
            'stok_id'       => $action === 'DELETE' ? null : $stokId,
            'action'        => $action,
            'data'          => self::canonicalJson($data),
            'actor'         => is_array($data) && isset($data['actor']) ? $data['actor'] : null,
            'previous_hash' => $previousHash ?? '0',
            'hash'          => $hash,
        ]);
    }

    /**
     * Validate a single block's hash (only hash, not chain)
     */
    public static function validateBlock(Block $block): bool
    {
        $data = json_decode($block->data, true);
        $calculatedHash = self::generateHash($data, $block->previous_hash, $block->action);
        
        return $block->hash === $calculatedHash;
    }

    /**
     * Validate chain integrity (sama seperti di BlockchainValidationController)
     */
    public static function validateChain($blocks)
    {
        if ($blocks->isEmpty()) {
            return true;
        }
        
        foreach ($blocks as $index => $block) {
            if ($index === 0) {
                // Genesis block
                if ($block->previous_hash !== '0') {
                    return false;
                }
            } else {
                $previousBlock = $blocks[$index - 1];
                if ($block->previous_hash !== $previousBlock->hash) {
                    return false;
                }
            }
            
            // Validate current block hash
            if (!self::validateBlock($block)) {
                return false;
            }
        }
        
        return true;
    }

    /**
     * Get validation results untuk semua blocks (sama seperti di BlockchainValidationController)
     */
    public static function getValidationResults()
    {
        $blocks = Block::orderBy('id')->get();
        $validBlocks = 0;
        $invalidBlocks = 0;
        $validationResults = [];
        
        foreach ($blocks as $block) {
            $isValid = self::validateBlock($block);
            
            if ($isValid) {
                $validBlocks++;
            } else {
                $invalidBlocks++;
            }
            
            $validationResults[] = [
                'block' => $block,
                'is_valid' => $isValid,
                'message' => $isValid ? 'Block valid' : 'Block corrupt - hash tidak cocok'
            ];
        }
        
        return [
            'blocks' => $blocks,
            'validBlocks' => $validBlocks,
            'invalidBlocks' => $invalidBlocks,
            'validationResults' => $validationResults,
            'chainValid' => self::validateChain($blocks)
        ];
    }

    /**
     * Update is_valid column di database
     */
    public static function updateValidationStatus(): void
    {
        $blocks = Block::orderBy('id')->get();
        
        foreach ($blocks as $block) {
            $isValid = self::validateBlock($block);
            $block->update(['is_valid' => $isValid]);
        }
    }
}
