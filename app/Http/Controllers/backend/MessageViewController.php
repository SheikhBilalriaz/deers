<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageViewController extends Controller
{
    /**
     * Apply authentication middleware to ensure only authenticated users
     * can access methods in this controller.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the messages view for the authenticated user.
     *
     * @return \Illuminate\View\View
     */
    public function messagesView()
    {
        // Get the currently authenticated user
        $user = Auth::user();

        // Prepare data to pass to the view
        $data = [
            'title' => ' Messages | Deers Admin Dashboard',
            'user' => $user,
        ];

        // Return the messages view with the prepared data
        return view('backend.messages', $data);
    }
}
