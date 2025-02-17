<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageParticipant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function messages($page = 0)
    {
        $user = Auth::user();
        $conversations = Conversation::where('created_by', $user->id)
            ->with('participants', 'createdBy', 'lastMessage', 'unreadMessages')
            ->skip($page * 1)
            ->take(1)
            ->get();
        if ($page > 0) return $conversations;
        $users = User::where('id', '!=', $user->id)->get();
        $data = [
            'title' => ' Messages | Deers Admin Dashboard',
            'chats' => $conversations,
            'users' => $users
        ];
        return view('backend.messages', $data);
    }

    public function getMessages($conversation_id, $page = 0)
    {
        $messages = Message::where('conversation_id', $conversation_id)
            ->with('files', 'sender')
            ->orderBy('created_at', 'desc')
            ->skip($page * 5)
            ->take(5)
            ->get();
        foreach ($messages as $message) {
            if ($message->sender->id !== Auth::user()->id) {
                $message->read_at = now();
                $message->save();
            }
        }
        return response()->json(['messages' => $messages]);
    }

    public function conversation_view_page()
    {
        $data  = [
            'title' => ' Inbox | Deers Admin Dashboard'
        ];
        return view('backend.inbox', $data);
    }
}
