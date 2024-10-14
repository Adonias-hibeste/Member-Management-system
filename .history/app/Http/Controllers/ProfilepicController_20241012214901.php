<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProfilepicController extends Controller
{
    public function uploadProfileImage(Request $request)
{
    try {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::find($request->user_id);
        $profile = $user->profile;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('profile_images', 'public');

            $profile->image = $imagePath;
            $profile->save();
        }

        return response()->json([
            'message' => 'Profile image uploaded successfully!',
            'profile' => [
                'image' => url('storage/profile_images' . $profile->image), // Ensure the filename is included
            ],
        ], 200);

    } catch (\Exception $e) {
        Log::error('Error uploading profile image: ' . $e->getMessage());
        return response()->json(['message' => 'Failed to upload image'], 500);
    }
}

}
