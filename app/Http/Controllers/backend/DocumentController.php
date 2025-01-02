<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;


class DocumentController extends Controller
{
    public function upload(Request $request)
    {
        // Validate the request to ensure all necessary data is provided
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,png,xls,xlsx|max:50000',
            'user_id' => 'required|integer|exists:users,id',
            'department' => 'required|string|max:255',
        ]);

        // Fetch user and their subscription details
        $user = User::find($request->user_id);
        $subscription = $user->userSubscriptions()->first(); // assuming the user has a 'userSubscription' relationship

        // Check if the user has an active subscription
        if (!$subscription || $subscription->end_date < now()) {
            return response()->json([
                'message' => 'Your subscription has expired or is invalid',
            ], 403);
        }

        // Get plan details
        $plan = $subscription->subscriptionPlan->name;

        // Handle restrictions based on plan
        if ($plan === 'Free Plan') {
            return response()->json([
                'message' => 'Document upload is not allowed for the Free Plan',
            ], 403);
        } elseif ($plan === 'Pro Plan') {
            // Check how many documents the user has uploaded this month
            $currentMonthUploads = Document::where('user_id', $user->id)
                ->whereMonth('created_at', now()->month)
                ->count();

            if ($currentMonthUploads >= 3) {
                return response()->json([
                    'message' => 'You have reached the maximum document upload limit for the Pro Plan this month (3 documents)',
                ], 403);
            }
        }

        // Handle the file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Generate a unique name for the file
            $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $generatedName = 'deers-doc-' . Str::slug($originalFileName) . '-' . time() . '.' . $extension;

            // Store the file in the 'documents' directory with the new name
            $path = $file->storeAs('documents', $generatedName);

            // Store document data in the database
            $document = Document::create([
                'user_id' => $request->user_id,
                'name' => $generatedName,
                'department' => $request->input('department'),
                'file_path' => $path,
            ]);

            return response()->json([
                'message' => 'File uploaded and data stored successfully',
                'document' => $document,
            ], 201);
        }

        return response()->json([
            'message' => 'No file uploaded',
        ], 400);
    }

    public function userDocs(Request $request)
    {
        $user_id = $request->user_id;
        $user_docs = Document::where('user_id', $user_id)->get();

        if ($user_docs->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No documents found for this user.',
                'data' => []
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'User documents retrieved successfully.',
            'data' => $user_docs
        ], 200);
    }
}
