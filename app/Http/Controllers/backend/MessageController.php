<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\ConversationParticipant;
use App\Models\Message;
use App\Models\MessageFile;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function fetchMessages($conversation_id, $page = 0)
    {
        try {
            // Query to retrieve messages for the given conversation, including associated files and sender details
            $query = Message::where('conversation_id', $conversation_id)
                ->with('files', 'sender')
                ->orderBy('created_at', 'desc')
                ->skip($page * config('app.pagination.count'))
                ->take(config('app.pagination.count'));

            // Process retrieved messages
            $messages = $query->get()->map(function ($message) {
                // Mark the message as read if it's not sent by the authenticated user
                if ($message->sender->id !== Auth::user()->id) {
                    $message->read_at = now();
                    $message->save();
                }

                return $message;
            });

            // Return messages along with conversation participants (only for the first page)
            return response()->json([
                'success' => true,
                'messages' => $messages,
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

    public function fetchRecentMessages($conversation_id)
    {
        try {
            // Get authenticated user
            $user = Auth::user();

            // Query to retrieve messages for the given conversation, including associated files and sender details
            $query = Message::where('conversation_id', $conversation_id)
                ->where('sender_id', '!=', $user->id)
                ->where('read_at', null)
                ->with('files', 'sender')
                ->orderBy('created_at', 'desc');

            // Process retrieved messages
            $messages = $query->get()->map(function ($message) {
                // Mark the message as read if it's not sent by the authenticated user
                if ($message->sender->id !== Auth::user()->id) {
                    $message->read_at = now();
                    $message->save();
                }

                return $message;
            });

            // Return messages along with conversation participants (only for the first page)
            return response()->json([
                'success' => true,
                'messages' => $messages,
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

    public function sendMessage(Request $request, $conversation_id = 0, $user_id = 0)
    {
        try {
            $request->validate([
                'typing' => 'nullable|string|max:5000',
                'file_upload' => 'nullable|file|max:20480',
            ]);

            if (!$request->input('typing') && !$request->file('file_upload')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Add a message to send or upload file'
                ], 400);
            }

            $sender = Auth::user();

            if ($conversation_id == 0) {
                if ($user_id == 0) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User Id not found'
                    ], 400);
                }

                $conversation = Conversation::create([
                    'type' => 'private',
                    'created_by' => $sender->id
                ]);

                $participants = [
                    ConversationParticipant::create([
                        'conversation_id' => $conversation->id,
                        'user_id' => $sender->id
                    ]),
                    ConversationParticipant::create([
                        'conversation_id' => $conversation->id,
                        'user_id' => $user_id
                    ]),
                ];

                $conversation_id = $conversation->id;
            }

            $sentMessage = Message::create([
                'conversation_id' => $conversation_id,
                'sender_id' => $sender->id,
                'message' => $request->input('typing') ?? '',
            ]);

            if ($request->file('file_upload')) {
                $file = $request->file('file_upload');
                if (!$file->isValid()) {
                    return response()->json(['success' => false, 'error' => 'Invalid file upload.'], 400);
                }
                $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('public/messages', $fileName);
                MessageFile::create([
                    'message_id' => $sentMessage->id,
                    'file_path' => "messages/$fileName",
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getMimeType(),
                ]);
            }

            $message = Message::with('files', 'sender')
                ->where('id', $sentMessage->id)
                ->first();

            $conversation = Conversation::with(['participantsExceptMe', 'createdBy', 'lastMessage', 'unreadMessages'])
                ->where('id', $conversation_id)
                ->first();

            if ($conversation) {
                $conversation->updated_at = now();
                $conversation->save();
            }

            return response()->json([
                'success' => true,
                'message' => $message,
                'chat' => $conversation
            ], 201);
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
}
