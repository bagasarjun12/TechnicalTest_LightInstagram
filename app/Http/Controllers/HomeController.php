<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reel; 
use App\Models\Image; 
use App\Models\Atribut; 
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua data dari tabel reels dengan eager loading untuk users dan images
        $reels = Reel::with('user')->orderBy('created_at', 'desc')->get();

        // Ambil semua data dari tabel atribut
        $atributs = Atribut::all();

        // Ganti id_gambar pada setiap reel dengan data dari images berdasarkan id_images
        foreach ($reels as $reel) {
            // Mencari image berdasarkan id_gambar
            $image = Image::find($reel->id_images);
            
            // Jika image ditemukan, ganti id_gambar dengan file dari images
            if ($image) {
                $reel->file = $image->file; // Ganti id_gambar dengan file dari images
                $reel->type_file = $image->type_file; // Tambahkan type_file ke objek reel
            }

            // Menambahkan username dan profile_picture ke objek reel
            if ($reel->user) {
                $reel->username = $reel->user->username; // Ganti dengan kolom yang sesuai di model User
                $reel->profile_picture = $reel->user->photo; // Ganti dengan kolom yang sesuai di model User
            }
        }

        // Mengembalikan view welcome dan mengirimkan data reels dan atribut
        return view('welcome', compact('reels', 'atributs'));
    }

    public function like(Request $request)
    {
        $id_reel = $request->input('reel_id');
        $user = Auth::user();
        $cek = Atribut::where('id_reels', $id_reel)
                  ->where('id_users', $user->id) 
                  ->first();

        if ($cek) {
            // Hapus data like
            $data = $cek;
            $data->delete();
            $msg = "Berhasil Batal Menyukai Postingan";
            $alertType = "primary"; // Tipe alert
        } else {
            // Buat dan Simpan data like

            $data = new Atribut();
            $data->id_reels = $id_reel;
            $data->id_users = $user->id;
            $data->type = "like";
            $data->save();
            $msg = "Berhasil Menyukai Postingan";
            $alertType = "success"; // Tipe alert
        }

        // Menyimpan pesan ke session
        session()->flash('alert', [
            'type' => $alertType,
            'message' => $msg,
        ]);

        // Redirect kembali ke halaman sebelumnya
        return redirect()->back();
    }

    public function upload_content(){
        //Code here
        return redirect()->back()->with('success', 'Content uploaded successfully.');
    }
}
