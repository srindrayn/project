<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Prodi;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use PhpParser\Node\Stmt\Return_;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        //
        $this->request = $request;
    }

    protected function jwt(Mahasiswa $mahasiswa)
    {
        $payload = [
            'iss' => 'lumen-jwt',
            'sub' => $mahasiswa->nim,
            'iat' => time(),
            'exp' => time() + 60
        ];
        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }

    public function registrasi(Request $request)
    {
        $nim = $request->nim;
        $nama = $request->nama;
        $angkatan = $request->angkatan;
        $password = Hash::make($request->password);
        $prodiId = $request->prodiId;

        $mahasiswa = Mahasiswa::create([
            'nim' => $nim,
            'nama' => $nama,
            'angkatan' => $angkatan,
            'password' => $password,
            'prodiId' => $prodiId
        ]);
        //*** */
        $program_studi = Prodi::find($mahasiswa->prodiId);
        return response()->json([
            'success' => true,
            'message' => 'Successfully registered',
            //'mahasiswa' => $mahasiswa
        ]);
    }

    //fungsi login user
    public function login(Request $request)
    {
        $nim = $request->nim;
        $password = $request->password;

        $mahasiswa = Mahasiswa::where('nim', $nim)->first();

        if (!$mahasiswa) {
            return response()->json([
                'status' => 'Error',
                'message' => 'mahasiswa not exist',
            ], 400);
        }

        if (!Hash::check($password, $mahasiswa->password)) {
            return response()->json([
                'status' => 'Error',
                'message' => 'wrong password',
            ], 400);
        }

        $mahasiswa->token = $this->jwt($mahasiswa);
        $mahasiswa->save();

        return response()->json([
            'success' => true,
            'message' => 'Successfully logged in',
            'token' => $mahasiswa->token
        ], 200);
    }

    //
}
