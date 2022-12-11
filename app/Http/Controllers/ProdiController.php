<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use Illuminate\Http\Request;

class ProdiController extends Controller
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

    //fungsi menambahkan prodi
    public function addProdi(Request $request)
    {
        $prodi = Prodi::create([
            'nama' => $request->nama
        ]);

        return response()->json([
            'success' => true,
            'message' => 'created successfull',
            'prodi' => $prodi
        ]);
    }

    //fungsi menampilkan semua prodi
    public function getAllProdi()
    {
        $getProdi = Prodi::all();

        return response()->json([
            'success' => true,
            'message' => 'grabbed all prodi',
            'prodi' => $getProdi
        ]);
    }
}
