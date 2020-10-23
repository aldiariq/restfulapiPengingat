<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //Method untuk mendaftarkan pengguna
    public function daftar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users',
            'name' => 'required|string',
            'password' => 'required|min:8'
        ]);

        if($validator->fails()){
            return response()->json([
                'BERHASIL' => false,
                'PESAN' => 'Gagal Registrasi'
            ], 401);
        }else {
            $pengguna = new User([
                'email' => $request->email,
                'name' => $request->name,
                'password' => bcrypt($request->password)
            ]);

            if($pengguna->save()){
                return response()->json([
                    'BERHASIL' => true,
                    'PESAN' => 'Berhasil Registrasi'
                ], 200);
            }else {
                return response()->json([
                    'BERHASIL' => false,
                    'PESAN' => 'Gagal Registrasi'
                ]);
            }
        }
    }

    //Method untuk autentikasi pengguna
    public function masuk(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:8',
            'remember' => 'required|boolean'
        ]);

        if($validator->fails()){
            return response()->json([
                'BERHASIL' => false,
                'PESAN' => 'Gagal Masuk'
            ], 401);
        }else {
            $datapengguna = [
                'email' => $request->email,
                'password' => $request->password
            ];

            if(Auth::attempt($datapengguna)){
                $datamasukpengguna = $request->user();
                $requesttoken = $datamasukpengguna->createToken('Token Akses');
                $tokenpengguna = $requesttoken->token;

                if($request->remember){
                    $tokenpengguna->expires_at = Carbon::now()->addWeekdays(4);
                }

                $tokenpengguna->save();

                return response()->json([
                    'BERHASIL' => true,
                    'PESAN' => 'Berhasil Masuk',
                    'TOKEN' => $datamasukpengguna->createToken('Token Akses')->accessToken,
                    'PENGGUNA' => $request->user()
                ], 200);
            }else {
                return response()->json([
                    'BERHASIL' => false,
                    'PESAN' => 'Gagal Masuk'
                ], 401);
            }
        }
    }

    //Method untuk logout pengguna
    public function keluar(Request $request)
    {
        if($request->user()->token()->revoke()){
            return response()->json([
                'BERHASIL' => true,
                'PESAN' => 'Berhasil Keluar'
            ], 200);
        }else {
            return response()->json([
                'BERHASIL' => true,
                'PESAN' => 'Gagal Keluar'
            ], 401);
        }
    }

    //Method untuk melihat data pengguna
    public function infopengguna(Request $request){
        return $this->success(Auth::user());
        if($request->user()->cekMasatoken()){
            return response()->json([
                'BERHASIL' => true,
                'PESAN' => 'Berhasil Mendapatkan Info',
                'PENGGUNA' => $request->user()
            ], 200);
        }else {
            return response()->json([
                'BERHASIL' => false,
                'PESAN' => 'Gagal Mendapatkan Info',
                'PENGGUNA' => null
            ], 401);
        }
    }
}
