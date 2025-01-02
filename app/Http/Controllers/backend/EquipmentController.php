<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\Departments;
use App\Models\User;
use Illuminate\Validation\ValidationException;



class EquipmentController extends Controller
{
    // Get All Equipments
    public function index()
    {
        $equipments = Equipment::with(['department', 'user'])->get();
        return response()->json($equipments);
    }

    public function getEquipmentByDepartmentID($department_id)
    {
        // Check if the department exists
        $departmentExists = Departments::where('id', $department_id)->exists();

        if (!$departmentExists) {
            return response()->json(['message' => 'Department not found.'], 404);
        }

        // Equipment ko department_id ke basis par retrieve karna
        $equipments = Equipment::where('department_id', $department_id)->with(['department', 'user'])->get();

        // Agar equipments nahi milte hain to 404 response dena
        if ($equipments->isEmpty()) {
            return response()->json(['message' => 'No equipment found for this department.'], 404);
        }

        return response()->json($equipments);
    }

    // Create Equipment
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'user_id' => 'required|exists:users,id',  // Spelling mistake fixed
                'department_id' => 'required|exists:departsments,id',  // Spelling mistake fixed
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'nullable|string',
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

            if ($plan === 'Free Plan') {
                return response()->json([
                    'message' => 'Adding equipment is not allowed for the Free Plan',
                ], 403);
            } elseif ($plan === 'Pro Plan') {
                // Check how many equipments the user has uploaded this month
                $currentMonthMaking = Equipment::where('user_id', $user->id)
                    ->whereMonth('created_at', now()->month)
                    ->count();

                if ($currentMonthMaking >= 3) {
                    return response()->json([
                        'message' => 'You have reached the maximum equipment adding limit for the Pro Plan this month (3 equipments)',
                    ], 403);
                }
            }

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('equipment_images', 'public');
                $validatedData['image'] = $imagePath;

                $equipment = Equipment::create($validatedData);
                return response()->json($equipment, 201);
            }

            return response()->json([
                'message' => 'No image uploaded',
            ], 400);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }

    // Get Single Equipment
    public function show($id)
    {
        $equipment = Equipment::find($id);

        if (!$equipment) {
            return response()->json(['message' => 'Equipment not found.'], 404);
        }

        $equipment = Equipment::where('id', $id)->with(['department', 'user'])->get();
        return response()->json($equipment);
    }

    // Update Equipment
    public function update(Request $request, $id)
    {
        try {

            $equipment = Equipment::find($id);

            // dd($equipment);
            if (!$equipment) {
                return response()->json(['message' => 'Equipment not found.'], 404);
            }
            // dd($equipment);
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'user_id' => 'required|exists:users,id',
                'department_id' => 'required|exists:departsments,id',  // Spelling mistake fixed
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'nullable|string',
            ]);

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('equipment_images', 'public');
                $validatedData['image'] = $imagePath;
            }

            $equipment->update($validatedData);
            return response()->json($equipment);
        } catch (ValidationException $e) {
            return response()->json([
                'errors' => $e->errors()
            ], 422);
        }
    }

    // Delete Equipment
    public function destroy($id)
    {

        $equipment = Equipment::find($id);
        // dd($equipment);
        if (!$equipment) {
            return response()->json(['message' => 'Equipment not found.'], 404);
        }

        $equipment->delete();

        return response()->json(['message' => 'Equipment deleted successfully']);
    }
}
