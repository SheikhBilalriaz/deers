<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Retrieve a list of users.
     *
     * @param mixed $onlyNonAdmin (optional) If provided, filters out admin users.
     * @return \Illuminate\Http\JsonResponse JSON response with user data.
     */
    public function getUsers($onlyNonAdmin = null)
    {
        try {
            // Get the authenticated user
            $user = Auth::user();

            // Initialize query to select all users except the authenticated user
            $query = User::select('*')->where('id', '!=', $user->id);

            // If $onlyNonAdmin is provided and evaluates to true, exclude admin users
            if (filter_var($onlyNonAdmin, FILTER_VALIDATE_BOOLEAN)) {
                $query->where('role', '!=', 'admin');
            }

            // Retrieve users from the database
            $users = $query->get();

            // Return successful JSON response with user data
            return response()->json([
                'success' => true,
                'users' => $users
            ], 200);
        } catch (Exception $e) {
            // Catch unexpected errors and return an error response
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong.',
                // Show error details only if debugging is enabled in .env (for security)
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
