<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Departments;
use App\Models\TimeSlot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

// use App\Http\Middleware\AdminMiddleware;

class DepartmentController extends Controller
{
    public function __construct()
    {
        // $this->middleware(AdminMiddleware::class);
        $this->middleware('auth');
    }

    public function departments()
    {
        $all_data = Departments::all();

        $data  = [

            'title' => ' Departments | Deers Admin Dashboard'
        ];

        return view('backend.departments' ,$data, compact('all_data'));
    }

    public function add_departments()
    {
        $data  = [

            'title' => ' Add Departments | Deers Admin Dashboard'
        ];

        return view('backend.add-department' ,$data);
    }

    public function add_departments_submit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'start_days' => 'required',
            'end_days' => 'required',
            'duration' => 'required|integer|min:1',
        ]);

        $data = $request->all();

        $userCoordinates = $this->getCoordinatesFromLocation($request->address);
        list($latitude, $longitude) = $userCoordinates;

        $data['latitude'] = $latitude;
        $data['longitude'] = $longitude;

        // dd($userCoordinates);

        if ($request->user()->role == 'admin') {
            $data['user_role'] = 'admin';
        } elseif ($request->user()->role == 'user_interface') {
            $data['user_role'] = 'user_interface';
        } else {
            $data['user_role'] = 'consultant_interface';
        }

        if (!$request->has('status')) {
            $data['status'] = 'inactive';
        }
        $data['user_id'] = $request->user()->id;

        $department = Departments::create($data);

        // Create the time slots based on the selected range of days and duration
        $daysRange = $this->getDaysRange($request->start_days, $request->end_days);

        foreach ($daysRange as $day) {
            $timeSlots = $this->generateTimeSlots((int) $request->duration); // Ensure duration is an integer
            foreach ($timeSlots as $slot) {
                TimeSlot::create([
                    'department_id' => $department->id,
                    'day' => $day,
                    'start_time' => $slot['start_time'],
                    'end_time' => $slot['end_time'],
                ]);
            }
        }

        return redirect()->route('departments')->with('success', 'Department added successfully');
    }

    private function getCoordinatesFromLocation($location)
    {
        $apiKey = 'AIzaSyAF9q3rW1aL52AJ_Yy2KIYVKQyjNn7PLIs';
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".urlencode($location)."&key=".$apiKey;


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Optional, depends on your server configuration

        $response = curl_exec($ch);
        curl_close($ch);

        // $response = file_get_contents($url);

        $json = json_decode($response, true);

        if ($json['status'] == 'OK') {
            $coordinates = $json['results'][0]['geometry']['location'];
            return [$coordinates['lat'], $coordinates['lng']];
        }

        return null;
    }


    protected function generateTimeSlots($duration)
    {
        $startTime = Carbon::createFromTime(9, 0); // Starting at 9 AM
        $endTime = Carbon::createFromTime(17, 0); // Ending at 5 PM
        $timeSlots = [];

        while ($startTime->lessThan($endTime)) {
            $endSlotTime = $startTime->copy()->addMinutes($duration);

            if ($endSlotTime->greaterThan($endTime)) {
                break;
            }

            $timeSlots[] = [
                'start_time' => $startTime->format('H:i'),
                'end_time' => $endSlotTime->format('H:i'),
            ];

            $startTime->addMinutes($duration);
        }

        return $timeSlots;
    }

    protected function getDaysRange($startDay, $endDay)
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $startIndex = array_search($startDay, $days);
        $endIndex = array_search($endDay, $days);

        if ($startIndex !== false && $endIndex !== false && $startIndex <= $endIndex) {
            return array_slice($days, $startIndex, $endIndex - $startIndex + 1);
        }

        return [];
    }

    public function edit_departments(Departments $department)
    {
        $data = [
            'title' => 'Edit Departments | Deers Admin Dashboard',
            'department' => $department
        ];

        return view('backend.edit-department', $data);
    }


    public function edit_departments_submit(Request $request, Departments $department)
    {
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
        ]);

        $data = $request->all();


        if(!$request->has('status')){
            $data['status'] = 'inactive';
        }

        // Determine the user_role based on some condition
        // if ($request->user()->role == 'admin') {
        //     $data['user_role'] = 'admin';
        // } elseif ($request->user()->role == 'user_interface') {
        //     $data['user_role'] = 'user_interface';
        // } else {
        //     $data['user_role'] = 'consultant_interface';
        // }

        $department->update($data);

        return redirect()->route('departments')->with('success', 'Department updated successfully');
    }
    public function destroy(Departments $department)
    {
        $department->delete();
        return redirect()->route('departments')->with('success', 'Department deleted successfully');
    }

}
