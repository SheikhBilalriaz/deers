<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

// use App\Http\Middleware\AdminMiddleware;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function dashboard()
    {
        $data  = [
            'title' => ' Dashboard |  Deers Admin Dashboard'
        ];

        return view('backend.dashboard', $data);
    }

    public function members()
    {
        $all_users = User::with('department')->get();
        $data = [
            'title' => 'Members | Deers Admin Dashboard',
            'all_users' => $all_users,
        ];

        return view('backend.members', $data);
    }

    public function add_members()
    {
        $alldepartments = Departments::all();
        $data  = [
            'title' => ' Add Members | Deers Admin Dashboard',
            'alldepartments' => $alldepartments,
        ];

        return view('backend.add-member', $data);
    }
    public function edit_members(User $user)
    {
        $alldepartments = Departments::all();
        $data  = [
            'title' => ' Edit Member | Deers Admin Dashboard',
            'alldepartments' => $alldepartments,
            'user' => $user,
        ];

        return view('backend.edit-members', $data);
    }

    public function edit_members_submit(Request $request, User $user)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->has('status')) {
            $status = 'active';
        } else {
            $status = 'inactive';
        }

        // Update user
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->name,
            'email' => $request->email,
            'department_id' => $request->department,
            'phone_number' => $request->phone_number,
            'rank' => $request->rank,
            'branch' => $request->branch,
            'years_of_experience' => $request->years_of_experience,
            'role' => $request->role,
            'status' => $status,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('members')->with('success', 'Member updated successfully');
    }


    public function add_members_submit(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create new user
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'name' => $request->name,
            'email' => $request->email,
            'department_id' => $request->department,
            'phone_number' => $request->phone_number,
            'rank' => $request->rank,
            'branch' => $request->branch,
            'years_of_experience' => $request->years_of_experience,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        // Redirect with success message
        return redirect()->route('members')->with('success', 'Member added successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('members')->with('success', 'Member deleted successfully');
    }



    public function add_appointments()
    {
        $data  = [
            'title' => ' Add Appointment | Deers Admin Dashboard'
        ];

        return view('backend.add-appointment', $data);
    }

    public function appointments()
    {
        // $appointments = Appointment::get();
        $appointments = Appointment::with(['department', 'user'])->get();

        $data  = [
            'title' => ' Appointments | Deers Admin Dashboard',
            'appointments' => $appointments,
        ];

        return view('backend.appointments', $data);
    }


    public function locations()
    {
        $data  = [

            'title' => ' Locations | Deers Admin Dashboard'
        ];

        return view('backend.locations', $data);
    }



    public function add_location()
    {
        $data  = [

            'title' => ' Add Location | Deers Admin Dashboard'
        ];

        return view('backend.add-location', $data);
    }

    public function subcsription()
    {
        $data  = [

            'title' => ' Subscription | Deers Admin Dashboard'
        ];

        return view('backend.subscription', $data);
    }

    public function reports()
    {
        $data  = [

            'title' => ' Reports | Deers Admin Dashboard'
        ];

        return view('backend.reports', $data);
    }

    public function invoices()
    {
        $data  = [

            'title' => ' Invoices | Deers Admin Dashboard'
        ];

        return view('backend.invoices', $data);
    }
}
