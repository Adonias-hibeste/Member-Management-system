<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProfilepicController extends Controller
{
    public function getUserProfile($userId)
    {
        try {
            $user = User::with('profile')->findOrFail($userId);
            return response()->json([
                'user' => $user,
                'profile' => $user->profile
            ], 200);
        } catch (\Exception $e) {
            Log::error('Error fetching user profile: ' . $e->getMessage());
            return response()->json(['message' => 'User profile not found'], 404);
        }
    }

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
                // Delete old image if exists
                if ($profile->image) {
                    Storage::disk('public')->delete($profile->image);
                }

                $image = $request->file('image');
                $imagePath = $image->store('profile_images', 'public');
                $profile->image = $imagePath;
                $profile->save();
            }

            return response()->json([
                'message' => 'Profile image uploaded successfully!',
                'profile' => [
                    'image' => url('storage/' . $profile->image),
                ],
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error uploading profile image: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to upload image'], 500);
        }
    }
}
