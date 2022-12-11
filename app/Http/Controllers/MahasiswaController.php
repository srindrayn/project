<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Laravel\Lumen\Http\Request as HttpRequest;

class MahasiswaController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //'nim', 'nama', 'password', 'angkatan', 'prodiId', 'token',
    public function addMahasiswa(Request $request)
    {
        $mahasiswa = Mahasiswa::create([
            'nim' => $request->nim,
            'nama' => $request->nama,
            'password' => $request->password,
            'angkatan' => $request->angkatan,
            'prodiId' => $request->prodiId
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'created successfull',
            'prodi' => $mahasiswa
        ]);
    }

    public function getAllMahasiswa()
    {
        // $getMahasiswa=Mahasiswa::all();
        $getMahasiswa = Mahasiswa::with('prodi')->get();

        return response()->json([
            'success' => true,
            'message' => 'grabbed all mahasiswa',
            'mahasiswa' => $getMahasiswa
        ]);
    }

    // public function getbyNIM($nim){
    //     $getbyNIM = Mahasiswa::find($nim);

    //     return response()->json([
    //         'success'=>true,
    //         'message'=>'created successfull',
    //         'mahasiswa'=>$getbyNIM
    //     ]);
    // }

    public function getMahasiswabyToken(Request $request)
    {
        $getbyToken = $request->mahasiswa;

        return response()->json([
            'success' => true,
            'message' => 'grabbed mahasiswa by token',
            'mahasiswa' => $getbyToken,
        ]);
    }

    public function getByNimm($nim)
    {
        $getbyNIM = Mahasiswa::with('matakuliah', 'prodi')->find($nim);
        return response()->json([
            'success' => true,
            'message' => 'grabbed one mahasiswa',
            'mahasiswa' => $getbyNIM,
        ]);
    }

    public function addMatkul($nim, $mkId, Request $request)
    {
        if ($request->mahasiswa->nim != $nim) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to added mata kuliah to Mahasiswa!'
            ]);
        }

        $mahasiswa = Mahasiswa::find($nim);
        $mahasiswa->matakuliah()->attach($mkId);

        return response()->json([
            'status' => 'success',
            'message' => 'Mata kuliah added to mahasiswa'
        ]);
    }

    public function deleteMatkul($nim, $mkId, Request $request)
    {
        if ($request->mahasiswa->nim != $nim) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to deleted mata kuliah from Mahasiswa!'
            ]);
        }

        $mahasiswa = Mahasiswa::find($nim);
        $mahasiswa->matakuliah()->detach($mkId);

        return response()->json([
            'status' => 'success',
            'message' => 'Mata kuliah deleted from mahasiswa'
        ]);
    }
}
