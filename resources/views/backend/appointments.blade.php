@extends('backend.partials.master')
@section('content')
    <div class="content">
<section class="secDashboard">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-2">
               @include('backend.partials.sidebar')
            </div>
            <div class="col-12 col-md-10">
                <div class="appoint_area bg_shade">
                    <div class="top_opt">
                        <h2 class="sec_head ft_oswlad">Appointments</h2>
                        <!-- <a href="{{route('add_appointments')}}" class="btn_custom add_member">Add New Appointment</a> -->
                    </div>
                    <table class="dt_table appintment table table-bordered table-hover dt-responsive">
                        <thead>
                        <tr>
                            <th>Member</th>
                            <th>Department</th>
                            <th>From - To</th>
                            <th>Duration</th>
                            <th>Appointment Date</th>
                            <th>Created Date</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($appointments as $appointment)
                        <?php
                        // Convert start_time and end_time to Carbon instances
                        $startTime = \Carbon\Carbon::parse($appointment['start_time']);
                        $endTime = \Carbon\Carbon::parse($appointment['end_time']);
                        
                        // Calculate the difference in hours and minutes
                        $duration = $startTime->diff($endTime);

                        // Get the current time
                        $currentTime = \Carbon\Carbon::now();
                            
                        // Determine the status
                        if ($currentTime->lt($endTime)) {
                            $status = 'Scheduled';
                            $statusClass = 'status red';  // Change status color or class as needed
                        } else {
                            $status = 'Completed';  // Or 'Expired', 'Done', etc.
                            $statusClass = 'status green';  // Change status color or class as needed
                        }

                        // Format the start_time and end_time to 12-hour format with AM/PM
                        $formattedStartTime = $startTime->format('h:i A');
                        $formattedEndTime = $endTime->format('h:i A');
                        ?>
                        <tr>
                            <td>
                                <div class="user_col">
                                    <!-- <img class="thumb" src="{{asset('dashboard_assets/images/thumb.png')}}" alt=""> -->
                                    {{ $appointment['department']['name']; }}
                                </div>
                            </td>
                            <td>{{ $appointment['user']['first_name']; }} {{ $appointment['user']['last_name']; }}</td>
                            <!-- <td>{{ $appointment['start_time']; }} - {{ $appointment['end_time']; }}</td> -->
                            <td>{{ $formattedStartTime }} - {{ $formattedEndTime }}</td>
                            <td>{{ $duration->h }}h {{ $duration->i }}m</td>
                            <td>{{ $appointment['date']; }}</td>
                            <td>{{ $appointment['created_at']; }}</td>
                            <td>
                                <div class="{{ $statusClass }}">{{ $status }}</div>
                            </td>
                            <td>
                                <!-- <a href="javascript:;" class="action_link">
                                    <img src="{{asset('dashboard_assets/images/icon_action.png')}}" alt="">
                                </a>
                                <div class="actions">
                                    <a href="javascript:;" class="viiew"><span class="icon"><i class="fa-solid fa-eye"></i></span>View</a>
                                    <a href="javascript:;" class="edit"><span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>Edit</a>
                                    <a href="javascript:;" class="delete"><span class="icon"><i class="fa-solid fa-trash"></i></span>Delete</a>
                                </div> -->
                            </td>
                        </tr>

                        @endforeach



                        

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
    </div>
@endsection
