<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pengingat;
use Exception;
use Illuminate\Support\Facades\Validator;


class PengingatController extends Controller
{
    //Method untuk menambahkan data pengingat
    public function tambahpengingat(Request $request){
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string',
            'keterangan' => 'required|string',
            'waktudeadline' => 'required|date'
        ]);

        if($validator->fails()){
            return response()->json([
                'BERHASIL' => false,
                'PESAN' => 'Gagal Menambahkan Pengingat'
            ], 401);
        }else {
            $pengingat = new Pengingat([
                'judul' => $request->judul,
                'keterangan' => $request->keterangan,
                'waktudeadline' => $request->waktudeadline
            ]);

            if($pengingat->save()){
                return response()->json([
                    'BERHASIL' => true,
                    'PESAN' => 'Berhasil Menambahkan Pengingat'
                ], 200);
            }else {
                return response()->json([
                    'BERHASIL' => false,
                    'PESAN' => 'Gagal Menambahkan Pengingat'
                ], 401);
            }
        }
    }

    //Method untuk melihat data pengingat
    public function lihatsemuapengingat(){
        $datapengingat = Pengingat::all();

        if($datapengingat){
            return response()->json([
                'BERHASIL' => true,
                'PESAN' => 'Berhasil Mendapatkan Pengingat',
                'PENGINGAT' => $datapengingat
            ], 200);
        }else {
            return response()->json([
                'BERHASIL' => false,
                'PESAN' => 'Gagal Mendapatkan Pengingat'
            ], 401);
        }
    }

    //Method untuk melihat salah satu data pengingat
    public function lihatsatupengingat($id){
        $datapengingat = Pengingat::find($id);

        if($datapengingat){
            return response()->json([
                'BERHASIL' => true,
                'PESAN' => 'Berhasil Mendapatkan Pengingat',
                'PENGINGAT' => $datapengingat
            ], 200);
        }else {
            return response()->json([
                'BERHASIL' => false,
                'PESAN' => 'Gagal Mendapatkan Pengingat'
            ], 401);
        }
    }

    //Method untuk mengubah satu pengingat
    public function ubahpengingat($id, Request $request){
        $validator = Validator::make($request->all(), [
            'judul' => 'required|string',
            'keterangan' => 'required|string',
            'waktudeadline' => 'required|date'
        ]);

        if($validator->fails()){
            return response()->json([
                'BERHASIL' => false,
                'PESAN' => 'Gagal Mengubah Pengingat'
            ], 401);
        }else {
            $datapengingat = Pengingat::find($id);
            $datapengingat->judul = $request->judul;
            $datapengingat->keterangan = $request->keterangan;
            $datapengingat->waktudeadline = $request->waktudeadline;

            if($datapengingat->save()){
                return response()->json([
                    'BERHASIL' => true,
                    'PESAN' => 'Berhasil Mengubah Pengingat'
                ], 200);
            }else {
                return response()->json([
                    'BERHASIL' => false,
                    'PESAN' => 'Gagal Mengubah Pengingat'
                ]);
            }
        }
    }

    //Method untuk menghapus satu pengingat
    public function hapuspengingat($id){
        $datapengingat = Pengingat::find($id);

        if($datapengingat->delete()){
            return response()->json([
                'BERHASIL' => true,
                'PESAN' => 'Berhasil Menghapus Pengingat'
            ], 200);
        }else {
            return response()->json([
                'BERHASIL' => false,
                'PESAN' => 'Gagal Menghapus Pengingat'
            ], 401);
        }
    }
}
