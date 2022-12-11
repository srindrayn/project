<?php

namespace App\Http\Controllers;

use App\Models\Matakuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
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

    //
    public function createMataKuliah(Request $request)
    {
        $matkul = Matakuliah::create([
            'nama' => $request->nama,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'created successfull',
            'matakuliah' => $matkul
        ]);
    }

    public function getMataKuliah()
    {
        $matkul = Matakuliah::all();

        return response()->json([
            'success' => true,
            'message' => 'grabbed all mata kuliah',
            'matakuliah' => $matkul
        ]);
    }
}
