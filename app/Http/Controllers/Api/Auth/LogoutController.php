<?php

namespace App\Http\Controllers\Api\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = auth()->user();

        // Check if the user is an advisor
        if ($user->hasRole('advisor')) {
            // Change the user role to 'seeker'
            $user->assignRole('seekers');
        }

        // Delete user tokens
        $user->tokens()->delete();

        // Return the response
        return $this->handleResponse(message: 'Logged out successfully');
    }
}
