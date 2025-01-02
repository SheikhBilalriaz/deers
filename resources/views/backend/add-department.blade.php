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
                <div class="add_member bg_shade">
                    <form action="{{route('add_departments_submit')}}" method="post" class="form" autocomplete="off" id="add_departments">
                        <div class="top_add">
                            <a href="{{route('departments')}}" class="btn_back">
                                <img src="{{asset('dashboard_assets/images/icon_left.png')}}" alt="">
                            </a>
                            <div class="ext">
                                <h2 class="sec_head ft_oswlad">Add Departments</h2>
                                <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
                            </div>
                            <input type="submit" name="submit" class="btn_custom" value="Add New Department">
{{--                            <a href="javascript:;" class="btn_custom"></a>--}}
                        </div>
                        <div class="add_form">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="field">
                                        <label for="dept_name">Department Name</label>
                                        <input type="text" class="form-control" id="dept_name" name="name" placeholder="Department">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="field drop_down">
                                        <label for="department">Select City</label>
                                        <select class="form-control" name="city" id="department">
                                            <option disabled selected>Select</option>
                                            <option value="New York">New York</option>
                                            <option value="New Jersey">New Jersey</option>
                                            <option value="California">California</option>
                                        </select>
                                        @error('city')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="field address">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" id="address" name="address" placeholder="Complete address">
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="field">
                                        <label for="phone_number">Phone Number</label>
                                        <input type="number" class="form-control" id="phone_number" name="phone" placeholder="+012 345 6789" autocomplete="off" required>
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="field">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" autocomplete="off">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <h4>Add Time Slots</h4>
                                </div>
                                <!-- Select Days Field -->
                                <div class="col-6">
                                    <div class="field drop_down">
                                        <label for="days">Select Days Start</label>
                                        <select class="form-control" name="start_days" id="days"  required>
                                            <option value="Monday">Monday</option>
                                            <option value="Tuesday">Tuesday</option>
                                            <option value="Wednesday">Wednesday</option>
                                            <option value="Thursday">Thursday</option>
                                            <option value="Friday">Friday</option>
                                        </select>
                                        @error('days')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="field drop_down">
                                        <label for="end_days">Select Days End</label>
                                        <select class="form-control" name="end_days" id="end_days"  required>
                                            <option value="Monday">Monday</option>
                                            <option value="Tuesday">Tuesday</option>
                                            <option value="Wednesday">Wednesday</option>
                                            <option value="Thursday">Thursday</option>
                                            <option value="Friday">Friday</option>
                                        </select>
                                        @error('days')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Appointment Duration Field -->
                                <div class="col-12">
                                    <div class="field">
                                        <label for="duration">Appointment Duration (minutes)</label>
                                        <input type="number" class="form-control" id="duration" name="duration" placeholder="Enter duration in minutes" required>
                                        @error('duration')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="field d-flex">
                                        <p>Status</p>
                                        <label class="switch">
                                            <input name="status" class="toggleButton" type="checkbox" checked>
                                            <span class="slider round"></span>
                                            <span class="text">Active</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
</div>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAF9q3rW1aL52AJ_Yy2KIYVKQyjNn7PLIs&libraries=places&callback=initMap" defer ></script>

<script>
    async function AutoFill() {
            const fromInput = document.getElementById('address');
            const fromAutocomplete = new google.maps.places.Autocomplete(fromInput);
        }

        window.onload = AutoFill;
</script>
@endsection
