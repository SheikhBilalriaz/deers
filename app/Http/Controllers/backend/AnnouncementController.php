<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Departments;

use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'content' => 'required|string',
            'doc' => 'nullable|file',
            'image' => 'nullable|image',
            // 'is_all_department' => 'required|boolean', // Required to determine if all departments are selected
            // 'department_id' is required only if 'is_all_department' is false
            // 'department_id' => 'required_if:is_all_department,false|exists:departments,id'
        ]);

        // Store the data
        $data = $request->only(['content', 'department_id', 'is_all_department']);
        
        // If 'is_all_department' is true, we nullify the 'department_id'
        if ($request->is_all_department) {            
            $data['department_id'] = 0;
            $data['is_all_department'] = 'true';          
        }

        // Handling file uploads
        if ($request->hasFile('doc')) {
            $data['doc'] = $request->file('doc')->store('docs', 'public');
        }
        
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('images', 'public');
        }

        // Create the announcement
        $announcement = Announcement::create($data);

        // Return a success response
        return response()->json([
            'message' => 'Announcement created successfully!',
            'announcement' => $announcement
        ], 201);
    }


    public function getByDepartment($department_id)
    {
        // Fetch all announcements where department_id matches
        $announcements = Announcement::where('department_id', $department_id)->get();

        // Append full URLs for doc and image
        foreach ($announcements as $announcement) {
            $announcement->doc = $announcement->doc ? url('storage/' . $announcement->doc) : null;
            $announcement->image = $announcement->image ? url('storage/' . $announcement->image) : null;
        }

        return response()->json($announcements);
    }

    public function allDepartments(Request $request)
    {
        // First, get all global announcements (where is_all_department is true)
        $globalAnnouncements = Announcement::where('is_all_department', 'true')->get();

        // dd($globalAnnouncements);
        // Then, check if department_id is passed in the request and fetch specific department announcements
        $departmentAnnouncements = collect();
        
        if ($request->has('department_id')) {
            $departmentAnnouncements = Announcement::where('department_id', $request->department_id)
                                    ->where('is_all_department', false) // Only fetch department-specific announcements
                                    ->get();
        }

        // Combine global announcements with department-specific ones
        $announcements = $globalAnnouncements->merge($departmentAnnouncements);

        // Iterate through each announcement to attach full URL to doc and image
        foreach ($announcements as $announcement) {
            $announcement->doc = $announcement->doc ? url('storage/' . $announcement->doc) : null;
            $announcement->image = $announcement->image ? url('storage/' . $announcement->image) : null;

            // Fetch the department details if the announcement is for a specific department
            if ($announcement->department_id !== 0) {
                $department = Departments::find($announcement->department_id);
                $announcement->department = $department ? [
                    'id' => $department->id,
                    'name' => $department->name,
                    'description' => $department->description
                ] : null;
            } else {
                // For global announcements, set department as "All Departments"
                $announcement->department = 'All Departments';
            }
        }

        // Return the response with combined announcements
        return response()->json([
            'announcements' => $announcements
        ]);
    }

}
