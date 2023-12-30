<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MahasiswaController extends Controller
{
    public function index()
    {
        $mahasiswa = Mahasiswa::latest()->get();

        return response()->json([
            'success' => true,
            'message' => 'List Data Mahasiswa',
            'data'    => $mahasiswa  
        ], 200);

    }

    public function show($id)
    {
        $mahasiswa = Mahasiswa::findOrfail($id);

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Mahasiswa',
            'data'    => $mahasiswa 
        ], 200);

    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nama'   => 'required',
            'jurusan' => 'required',
            'angkatan' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $mahasiswa = Mahasiswa::create([
            'nama'     => $request->nama,
            'jurusan'   => $request->jurusan,
            'angkatan'   => $request->angkatan
        ]);

        if($mahasiswa) {

            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa Di tambahkan',
                'data'    => $mahasiswa  
            ], 201);

        } 

        return response()->json([
            'success' => false,
            'message' => 'Mahasiswa Gagal di Tambahkan',
        ], 409);

    }

    public function update(Request $request, mahasiswa $mahasiswa)
    {
        $validator = Validator::make($request->all(), [
            'nama'   => 'required',
            'jurusan' => 'required',
            'angkatan' => 'required',
        ]);
        
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $mahasiswa = Mahasiswa::findOrFail($mahasiswa->id);

        if($mahasiswa) {

            $mahasiswa->update([
                'nama'     => $request->nama,
                'jurusan'   => $request->jurusan,
                'angkatan'   => $request->angkatan
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa di Perbaharui',
                'data'    => $mahasiswa  
            ], 200);

        }

        return response()->json([
            'success' => false,
            'message' => 'Mahasiswa Tidak ada',
        ], 404);

    }

    public function destroy($id)
    {
        $mahasiswa = Mahasiswa::findOrfail($id);

        if($mahasiswa) {

            $mahasiswa->delete();

            return response()->json([
                'success' => true,
                'message' => 'Mahasiswa Di Hapus',
            ], 200);

        }

        return response()->json([
            'success' => false,
            'message' => 'Mahasiswa Tidak ada',
        ], 404);
    }
}
