<?php

namespace App\Http\Controllers;

use App\Models\keluhan_pelanggan;
use App\Models\keluhan_status_his;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KeluhanPelangganController extends Controller
{

    function index() {

        $keluhan = keluhan_pelanggan::orderBy('created_at', 'asc')->get();

        return response()->json([$keluhan], 200);
    }

    function postCreate(Request $request) {

        $validator = Validator::make($request->all(), [
            'keluhan' => 'required|string|min:50',
            'name' => 'required|min:3',
            'phone' => 'required|min:11|max:15|regex:/^[0-9]+$/'
        ], [
            'keluhan.min' => 'Keluhan harus memiliki minimal :min karakter.',
            'name.min' => 'name harus memiliki minimal :min karakter.',
            'phone.regex' => 'Phone number harus berupa angka saja.',
            'phone.min' => 'Phone number harus memiliki minimal :min karakter.',
            'phone.max' => 'Phone number maximal :max karakter.'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $create_keluhan = keluhan_pelanggan::create([
            'nama' => $request->name,
            'email' => $request->email,
            'nomor_hp' => $request->phone,
            'status_keluhan' => '0',
            'keluhan' => $request->keluhan
        ]);


        if (!$create_keluhan) {
            return response()->json(['error' => 'Gagal menyimpan keluhan.'], 500);
        }

        $create_status_history = keluhan_status_his::create([
            'keluhan_id' => $create_keluhan->id,
            'status_keluhan' => '0'
        ]);

        if (!$create_status_history) {
            return response()->json(['error' => 'Gagal menyimpan riwayat status keluhan.'], 500);
        }

        return response()->json([
            'message' => 'Keluhan berhasil diajukan',
            'keluhan' => $create_keluhan
        ], 200);

    }

    function detail($id) {
        $keluhan = keluhan_pelanggan::findOrFail($id);

        return response()->json([$keluhan], 200);
    }

    function update(Request $request, $id) {

        $validator = Validator::make($request->all(), [
            'keluhan' => 'string|min:50',
            'name' => 'min:3',
            'nomor_hp' => 'min:11|max:15|regex:/^[0-9]+$/'
        ], [
            'keluhan.min' => 'Keluhan harus memiliki minimal :min karakter.',
            'name.min' => 'name harus memiliki minimal :min karakter.',
            'nomor_hp.regex' => 'Phone number harus berupa angka saja.',
            'nomor_hp.min' => 'Phone number harus memiliki minimal :min karakter.',
            'nomor_hp.max' => 'Phone number maximal :max karakter.'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $keluhan = keluhan_pelanggan::findOrFail($id);
        $keluhan->nama = $request->nama;
        $keluhan->email = $request->email;
        $keluhan->nomor_hp = strval($request->nomor_hp);
        $keluhan->status_keluhan = $request->status == null ? intval($request->status_keluhan): $request->status ;
        $keluhan->keluhan = $request->keluhan;
        $keluhan->save();

        $keluhan_status = keluhan_status_his::where('keluhan_id', $id)->first();
        $keluhan_status->status_keluhan = $request->status;
        $keluhan_status->save();

        return response()->json([$keluhan], 200);
    }

    public function export($format)
    {
        $keluhan = keluhan_pelanggan::orderBy('created_at', 'asc')->get();

        $export = $format;

        if ($format === 'txt') {
            return response()->json([$export], 200);
        } elseif ($format === 'csv') {
            return response()->json([$export], 200);
        } elseif ($format === 'xls') {
            return response()->json([$export], 200);
        } elseif ($format === 'pdf') {
            return response()->json([$export], 200);
        }

        // Kembalikan file ekspor atau response sesuai kebutuhan
    }

}
