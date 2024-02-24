<?php

namespace App\Http\Controllers\Api\Auth;

use Carbon\Carbon;
use App\Models\Seeker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Auth\UpdateProfileRequest;
use App\Http\Resources\Auth\UpdateProfileResources;

class UpdateProfileController extends Controller
{
    public function __invoke(Request $request)
    {
        // Retrieve the authenticated user
        $userId = Auth::id();
        $seeker = Seeker::find($userId);

        // Validate the request data directly within the update call
        $validatedData = $request->validate([
            'name' => ['sometimes', 'string', 'min:3', 'max:25'],
            'email' => ['sometimes', 'email', 'unique:seekers,email,' . $seeker->id],
            'date_birth' => ['sometimes', 'date_format:d/m/Y', 'before_or_equal:' . now()->subYears(16)->format('d/m/Y'), 'after_or_equal:' . now()->subYears(70)->format('d/m/Y')],
            'image' => ['sometimes', 'image', 'mimes:jpg,jpeg,png,webp,gif', 'min:50', 'max:8000']
        ]);

        // Convert date_birth format to 'Y-m-d'
        if (isset($validatedData['date_birth'])) {
            $validatedData['date_birth'] = Carbon::createFromFormat('d/m/Y', $validatedData['date_birth'])->format('Y-m-d');
        }

        $imageUrl = null;

        if ($request->hasFile('image')) {
            // Store the new image
            $media = $seeker->addMediaFromRequest('image')->toMediaCollection('seeker_profile_image');
            $seeker->getFirstMedia('seeker_profile_image')->delete();

            // Get the URL of the new image
            $imageUrl = Storage::url($media->getPath());
        }





        // Update the seeker with validated data
        $seeker->update($validatedData);

        return response()->json([
            'status' => true,
            'message' => 'Successfully updated profile for ' . $seeker->email,
            'data' => new UpdateProfileResources($seeker)
        ]);
    }
}
