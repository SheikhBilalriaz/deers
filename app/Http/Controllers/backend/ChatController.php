<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\MessageParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function messages()
    {
        $user = Auth::user();
        $conversations = Conversation::where('created_by', $user->id)
            ->with('participants', 'createdBy', 'lastMessage', 'unreadMessages')
            ->get();
        $data  = [
            'title' => ' Messages | Deers Admin Dashboard',
            'chats' => $conversations
        ];
        return view('backend.messages', $data);
    }

    public function getMessages($conversation_id, $page = 0)
    {
        $messages = Message::where('conversation_id', $conversation_id)
            ->with('files')
            ->orderBy('created_at', 'desc')
            ->skip($page * 15)
            ->take(15)
            ->get();
        return response()->json($messages);
    }

    public function conversation_view_page()
    {
        $data  = [
            'title' => ' Inbox | Deers Admin Dashboard'
        ];
        return view('backend.inbox', $data);
    }
}
