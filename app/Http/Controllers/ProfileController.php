<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Models\Reel; 
use App\Models\Atribut; 
use App\Models\Image; 
use App\Models\Archive; 

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'email' => 'required|email|unique:users,email,' . $request->user()->id,
            // Add other validation rules as needed
        ]);

        // Update the user's email
        $user = $request->user();
        $user->email = $request->email;

        // Check if the email has changed
        if ($user->isDirty('email')) {
            // Set email_verified_at to null if the email has changed
            $user->email_verified_at = null;
        }

        // Save the user
        $user->save();

        // Return back with a success message
        return back()->with('success', 'Email updated successfully.');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function index()
    {
        // Get the currently authenticated user
        $user = auth()->user();
        // Retrieve reels associated with the user
        $reels = Reel::where('id_users', $user->id)->orderBy('created_at', 'desc')->get();
        if($reels->isEmpty()){
            $reels_count = 0;
        }else{
            // Ganti id_gambar pada setiap reel dengan data dari images berdasarkan id_images
            foreach ($reels as $reel) {
                // Mencari image berdasarkan id_gambar
                $image = Image::find($reel->id_images);
                
                // Jika image ditemukan, ganti id_gambar dengan file dari images
                if ($image) {
                    $reel->file = $image->file; // Ganti id_gambar dengan file dari images
                    $reel->type_file = $image->type_file; // Tambahkan type_file ke objek reel
                }
            }
            $reels_count = Reel::where('id_users', $user->id)->count();
        }

        // Retrieve attributes associated with the user
        $attributes = Atribut::all();
        // Count the number of archives associated with the user
        $archiveCount = Archive::where('id_users', $user->id)->get();
        if($archiveCount->isEmpty()){
            $archiveCount = 0;
        }else{
            $archiveCount = Archive::where('id_users', $user->id)->count();
        }
        // Pass the data to the view
        return view('account', [
            'user' => $user,
            'reels' => $reels,
            'atribut' => $attributes,
            'archive_count' => $archiveCount,
            'reels_count' => $reels_count,
        ]);
    }

    public function archive($id)
    {
        // Find the reel by ID
        $reel = Reel::findOrFail($id);

        //Grab reel like
        $like = Atribut::where('id_reels', $id)
                        ->where('type', 'like')->count();
        // Create a new archive entry with the data from the reel

        $archive = new Archive();
        $archive->id_users = Auth::id(); // Assuming the user is authenticated
        $archive->id_images = $reel->id_images; // Assuming the reel has an id_images attribute
        $archive->caption = $reel->caption; // Assuming the reel has a caption attribute
        if($like){
            $archive->like = $like;
        }else{
            $archive->like = 0;
        }
        $archive->upload_date = $reel->created_at; // Assuming the reel has a like attribute
        $archive->save(); // Save the archive entry

        // Delete the reel
        $reel->delete();

        // Redirect back with a success message
        return back()->with('success', 'Content has been archived successfully.');
    }

    public function profile_update(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'biodata' => 'required|string|max:1000',
            'photo' => 'nullable|image|max:15360', // 15MB in kilobytes
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Update user information
        $user->biodata = $request->input('biodata');
        // Handle the photo upload
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($user->photo) {
                Storage::delete('public/images/' . $user->photo);
            }
        
            // Get the original filename and extension
            $originalFilename = pathinfo($request->file('photo')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->file('photo')->getClientOriginalExtension();
        
            // Generate a new filename with a random number
            $randomNumber = rand(1000, 9999); // You can adjust the range as needed
            $newFilename = $originalFilename . '-' . $randomNumber . '.' . $extension;
        
            // Store the new photo in the public/images directory
            $photoPath = $request->file('photo');
            $photoPath->move(public_path().'/images/', $newFilename);
            $user->photo = $newFilename; // Store only the filename
        }

        // Save the updated user information
        $user->save();

        // Redirect back with a success message
        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully.');
    }

    public function del_reel($id)
    {
        // Delete data reel
        $data = Reel::find($id);
        $data->delete();

        return back()->with('success', 'Delete content successfully.');
    }
}
