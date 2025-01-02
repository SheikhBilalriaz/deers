<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Departments;
use App\Models\User;
use App\Models\TimeSlot;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::with(['department', 'user'])->get();
        return response()->json($appointments);
    }

    public function departmentUers(Request $request)
    {
        // Retrieve users based on the department_id
        $dep_users = User::where('department_id', $request->department_id)->get();

        // Check if users are found
        if ($dep_users->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No users found for this department.',
            ], 404);
        }

        // Return a proper JSON response with status and data
        return response()->json([
            'status' => 'success',
            'data' => $dep_users,
        ], 200);
    }

    public function departmentAppointmnets(Request $request)
    {
        // Retrieve users based on the department_id
        $dep_appointmnets = Appointment::where('department_id', $request->department_id)->with(['department', 'user'])->get();

        // Check if users are found
        if ($dep_appointmnets->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No Appointmnets found for this department.',
            ], 404);
        }

        // Return a proper JSON response with status and data
        return response()->json([
            'status' => 'success',
            'data' => $dep_appointmnets,
        ], 200);
    }


    public function userAppointment($id)
    {
        $appointments = Appointment::where('user_id', $id)->with(['department', 'user'])->get();

        if (!$appointments) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

        return response()->json($appointments);
    }

    public function store(Request $request)
    {

        try {
            $request->validate([
                'department_id' => 'required|exists:departsments,id',
                'date' => 'required|date',
                'user_id' => 'required|exists:users,id',
                'start_time' => 'required',
                'end_time' => 'required',
            ]);

            // Check if an appointment with the same date, start time, end time, and department already exists
            $existingAppointment = Appointment::where('department_id', $request->department_id)
                ->whereDate('date', $request->date)
                ->whereTime('start_time', $request->start_time)
                ->whereTime('end_time', $request->end_time)
                ->first();

            if ($existingAppointment) {
                return response()->json(['error' => 'An appointment with the same deatils exists.'], 409);
            }

            // Fetch user and their subscription details
            $user = User::find($request->user_id);
            $subscription = $user->userSubscriptions()->first(); // assuming the user has a 'userSubscription' relationship

            // Check if the user has an active subscription
            if (!$subscription || $subscription->end_date < now()) {
                return response()->json([
                    'error' => 'Your subscription has expired or is invalid',
                ], 403);
            }

            // Get plan details
            $plan = $subscription->subscriptionPlan->name;

            if ($plan === 'Free Plan') {
                return response()->json([
                    'error' => 'Making appointement is not allowed for the Free Plan',
                ], 403);
            } elseif ($plan === 'Pro Plan') {
                // Check how many appointments the user has uploaded this month
                $currentMonthMaking = Appointment::where('user_id', $user->id)
                    ->whereMonth('created_at', now()->month)
                    ->count();

                if ($currentMonthMaking >= 3) {
                    return response()->json([
                        'error' => 'You have reached the maximum appointment making limit for the Pro Plan this month (3 appointments)',
                    ], 403);
                }
            }

            // Proceed with creating the appointment
            $appointment = Appointment::create([
                'department_id' => $request->department_id,
                'user_id' => $request->user_id,
                'date' => $request->date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'status' => 'awaited',
            ]);

            $department = Departments::find($request->department_id);
            $departmentName = $department->name;

            // Calculate the duration in minutes
            $startTime = Carbon::parse($request->start_time);
            $endTime = Carbon::parse($request->end_time);
            $duration = $startTime->diffInMinutes($endTime);

            // Add the duration to the response
            $response = $appointment->toArray();
            $response['duration'] = $duration;
            $response['department_name'] = $departmentName;
            return response()->json($response, 201);
            // return response()->json($appointment, 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json($e->errors(), 422);
        }
    }

    public function approveDisapprove(Request $request, $id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found.'], 404);
        }

        $request->validate([
            'status' => 'required|in:awaited,approved,disapproved',
        ]);

        $appointment->status = $request->status;
        $appointment->save();

        return response()->json(['message' => 'Appointment status updated successfully.']);
    }

    public function show($appointment)
    {
        $appointments = Appointment::with(['department', 'user'])->find($appointment);

        if (!$appointments) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

        return response()->json($appointments);
    }

    public function checkAvailability($departmentId, $date)
    {
        // Retrieve the department
        $department = Departments::find($departmentId);

        if (!$department) {
            return response()->json(['error' => 'Department not found'], 404);
        }

        // Retrieve appointments for the department on the specified date
        $appointments = Appointment::where('department_id', $departmentId)
            ->whereDate('date', $date)
            ->get();

        // Retrieve the time slots for the department based on the day of the week
        $dayOfWeek = Carbon::parse($date)->format('l');
        $timeSlots = TimeSlot::where('department_id', $departmentId)->where('day', $dayOfWeek)->get();

        // If no time slots are found for the day, return an error (assuming weekends or non-working days)
        if ($timeSlots->isEmpty()) {
            return response()->json(['error' => 'No available time slots for this day'], 404);
        }

        // Check availability by comparing time slots with booked appointments
        $availability = $timeSlots->map(function ($slot) use ($appointments) {
            $isBooked = $appointments->contains(function ($appointment) use ($slot) {
                return $slot->start_time === $appointment->start_time
                    && $slot->end_time === $appointment->end_time;
            });

            return [
                'start_time' => $slot->start_time,
                'end_time' => $slot->end_time,
                'is_booked' => $isBooked,
            ];
        });

        return response()->json($availability->values()->all());
    }

    public function appDepartments()
    {
        $all_data = Departments::all();

        return response()->json([
            'message' => 'All Departments',
            'departments' => $all_data,
        ], 201);
    }

    public function update(Request $request, Appointment $appointment)
    {
        $request->validate([
            'department_id' => 'sometimes|exists:departsments,id',
            'date' => 'sometimes|date',
            'start_time' => 'sometimes|required_with:end_time',
            'end_time' => 'sometimes|required_with:start_time',
        ]);

        // Check if an appointment with the same date, start time, end time, and department already exists
        if ($request->has(['department_id', 'date', 'start_time', 'end_time'])) {
            $existingAppointment = Appointment::where('department_id', $request->department_id)
                ->whereDate('date', $request->date)
                ->whereTime('start_time', $request->start_time)
                ->whereTime('end_time', $request->end_time)
                ->first();

            if ($existingAppointment && $existingAppointment->id !== $appointment->id) {
                return response()->json(['error' => 'An appointment with the same date and time already exists for this department.'], 409);
            }
        }

        $appointment->update($request->only(['department_id', 'date', 'start_time', 'end_time']));
        return response()->json($appointment);
    }

    public function destroy($id)
    {
        $appointment = Appointment::find($id);

        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }

        $appointment->delete();
        return response()->json(['message' => 'Appointment deleted successfully'], 200);
    }
}
