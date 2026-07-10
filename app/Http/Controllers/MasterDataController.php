<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MasterBarang;
use App\Models\MasterPetani;
use App\Services\ActivityLogService;

class MasterDataController extends Controller
{
    // ======================================
    // MASTER BARANG
    // ======================================
    public function indexBarang()
    {
        $barangs = MasterBarang::orderBy('nama_barang')->get();
        return view('partials.master_barang', compact('barangs'));
    }

    public function storeBarang(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $barang = MasterBarang::create($request->all());
        ActivityLogService::log('create', "Menambah master barang: {$barang->nama_barang}", 'MasterBarang', $barang->id);

        return response()->json(['message' => 'Data barang berhasil ditambahkan!']);
    }

    public function updateBarang(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $barang = MasterBarang::findOrFail($id);
        $old = $barang->toArray();
        $barang->update($request->all());
        ActivityLogService::log('update', "Mengubah master barang: {$barang->nama_barang}", 'MasterBarang', $barang->id, $old, $barang->toArray());

        return response()->json(['message' => 'Data barang berhasil diubah!']);
    }

    public function destroyBarang($id)
    {
        $barang = MasterBarang::findOrFail($id);
        $nama = $barang->nama_barang;
        $barang->delete();
        ActivityLogService::log('delete', "Menghapus master barang: {$nama}", 'MasterBarang', $id);

        return response()->json(['message' => 'Data barang berhasil dihapus!']);
    }

    // ======================================
    // MASTER PETANI
    // ======================================
    public function indexPetani()
    {
        $petanis = MasterPetani::orderBy('nama_petani')->get();
        return view('partials.master_petani', compact('petanis'));
    }

    public function storePetani(Request $request)
    {
        $request->validate([
            'nama_petani' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        $petani = MasterPetani::create($request->all());
        ActivityLogService::log('create', "Menambah master petani: {$petani->nama_petani}", 'MasterPetani', $petani->id);

        return response()->json(['message' => 'Data petani berhasil ditambahkan!']);
    }

    public function updatePetani(Request $request, $id)
    {
        $request->validate([
            'nama_petani' => 'required|string|max:255',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
        ]);

        $petani = MasterPetani::findOrFail($id);
        $old = $petani->toArray();
        $petani->update($request->all());
        ActivityLogService::log('update', "Mengubah master petani: {$petani->nama_petani}", 'MasterPetani', $petani->id, $old, $petani->toArray());

        return response()->json(['message' => 'Data petani berhasil diubah!']);
    }

    public function destroyPetani($id)
    {
        $petani = MasterPetani::findOrFail($id);
        $nama = $petani->nama_petani;
        $petani->delete();
        ActivityLogService::log('delete', "Menghapus master petani: {$nama}", 'MasterPetani', $id);

        return response()->json(['message' => 'Data petani berhasil dihapus!']);
    }
}
