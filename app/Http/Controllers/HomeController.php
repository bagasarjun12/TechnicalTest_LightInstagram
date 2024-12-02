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

    public function upload_content(Request $request) {
        // Validate the incoming request
        $request->validate([
            'photo' => 'required|file|mimes:jpg,jpeg,png,mp4,mov|max:150000', // Max size is 150 MB
            'caption' => 'nullable|string|max:255',
        ]);
        // Handle the file upload
        if ($request->hasFile('photo')) {
            // Get the uploaded file
            $file = $request->file('photo');
    
            // Determine the file type (image or video)
            $fileType = $file->getClientOriginalExtension();
            $fileTypeLabel = in_array($fileType, ['jpg', 'jpeg', 'png']) ? 'image' : 'video'; // Set type as 'image' or 'video'
    
            // Create a unique file name with a random number
            $randomNumber = rand(1000, 9999); // Generate a random number
            if($fileTypeLabel == 'image'){
                $fileName = time() . '_' . $randomNumber . '_LIimage.'.$fileType; 
            }else{
                $fileName = time() . '_' . $randomNumber . '_LIvideo.'.$fileType; 
            }
           
            // Store the file in the public/images directory
            if($fileTypeLabel == 'image'){
                $file->move(public_path('reels'), $fileName);
            }else{
                $file->move(public_path('videos'), $fileName);
            }
    
            // Create a new image record in the images table
            $image = new Image();
            $image->type_file = $fileTypeLabel; // Store 'image' or 'video'
            $image->file = $fileName; // Store the file path
            $image->save(); // Save the image record
    
            // Create a new reel record in the reels table
            $reel = new Reel();
            $reel->id_users = auth()->id(); // Get the authenticated user's ID
            $reel->id_images = $image->id_images; // Link to the uploaded image
            if($request->caption){
                $reel->caption = $request->caption; // Store the caption
            }else{
                $reel->caption = 'This Post Does Not Have A Caption';
            }
            $reel->save(); // Save the reel record
            $msg = "Content uploaded successfully.";
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
}
