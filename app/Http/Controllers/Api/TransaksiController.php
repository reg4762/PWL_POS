<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TransaksiPenjualanModel;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        return TransaksiPenjualanModel::all();
    }

    public function store(Request $request)
    {
        $transaksi = TransaksiPenjualanModel::create($request->all());
        return response()->json($transaksi, 201);
    }


    public function show($id)
    {
        $transaksi = TransaksiPenjualanModel::find($id);

        // Jika transaksi ditemukan
        if ($transaksi) {
            return response()->json([
                'success' => true,
                'transaksi' => $transaksi,
            ], 200);
        }

        // Jika transaksi tidak ditemukan
        return response()->json([
            'success' => false,
            'message' => 'Transaksi not found.',
        ],404);
    }
    public function update(Request $request, TransaksiPenjualanModel $transaksi)
    {
        $transaksi->update($request->all());
        return TransaksiPenjualanModel::find($transaksi);
    }

    public function destroy(TransaksiPenjualanModel $transaksi)
    {
        $transaksi->delete();
        return response()->json([
            'success' => true,
            'message' => 'Data terhapus',
        ]);
    }
}