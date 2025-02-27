<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Exception;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function fetchChats($page = 0)
    {
        try {
            // Get the authenticated user
            $user = Auth::user();

            // Retrieve conversations where the user is either the creator or a participant
            $chats = Conversation::where(function ($query) use ($user) {
                $query->where('created_by', $user->id)
                    ->orWhereHas('participants', function ($subQuery) use ($user) {
                        $subQuery->where('user_id', $user->id);
                    });
            })
                // Load related data: participants, creator, last message, and unread messages
                ->with(['participantsExceptMe', 'createdBy', 'lastMessage', 'unreadMessages'])
                ->orderByDesc('updated_at')
                ->skip($page * config('app.pagination.count'))
                ->take(config('app.pagination.count'))
                ->get();

            // Return a JSON response with the chat data
            return response()->json([
                'success' => true,
                'chats' => $chats
            ], 200);
        } catch (Exception $e) {
            // Catch any unexpected errors and return a JSON error response
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong.',
                // Include the error message only if debugging is enabled in .env for security reasons
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function fetchUserChat($userId)
    {
        try {
            // Get the currently authenticated user
            $me = Auth::user();

            // Find a private conversation between the authenticated user and the target user
            $conversation = Conversation::where('type', 'private')
                ->whereHas('participants', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->whereHas('participants', function ($query) use ($me) {
                    $query->where('user_id', $me->id);
                })
                ->with(['participantsExceptMe', 'createdBy', 'lastMessage', 'unreadMessages'])
                ->first();

            if (!$conversation) {
                return response()->json([
                    'success' => true,
                    'chat' => null,
                ], 200);
            }

            return response()->json([
                'success' => true,
                'chat' => $conversation
            ], 200);
        } catch (Exception $e) {
            // Catch any unexpected errors and return a JSON error response
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong.',
                // Include the error message only if debugging is enabled in .env for security reasons
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function fetchRecentChats()
    {
        try {
            // Get the authenticated user
            $user = Auth::user();

            $chats = Conversation::where(function ($query) use ($user) {
                $query->where('created_by', $user->id)
                    ->orWhereHas('participants', function ($subQuery) use ($user) {
                        $subQuery->where('user_id', $user->id);
                    });
            })
                ->whereHas('unreadMessages', function ($subQuery) use ($user) {
                    $subQuery->where('sender_id', '!=', $user->id);
                })
                ->with(['participantsExceptMe', 'createdBy', 'lastMessage', 'unreadMessages'])
                ->orderByDesc('updated_at')
                ->get();

            return response()->json([
                'success' => true,
                'chats' => $chats
            ], 200);
        } catch (Exception $e) {
            // Catch any unexpected errors and return a JSON error response
            return response()->json([
                'success' => false,
                'error' => 'Something went wrong.',
                // Include the error message only if debugging is enabled in .env for security reasons
                'message' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    public function conversation_view_page()
    {
        $data  = [
            'title' => ' Inbox | Deers Admin Dashboard'
        ];
        return view('backend.inbox', $data);
    }
}
