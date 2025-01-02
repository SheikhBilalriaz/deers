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
                <form action="{{ route('members.edit.submit', $user->id) }}" method="post" class="form" autocomplete="off">
                    @csrf  <!-- CSRF Token -->
                    <div class="top_add">
                        <a href="{{ route('members') }}" class="btn_back">
                            <img src="{{ asset('dashboard_assets/images/icon_left.png') }}" alt="">
                        </a>
                        <div class="ext">
                            <h2 class="sec_head ft_oswlad">Edit Members</h2>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
                        </div>
                        <input type="submit" class="btn_custom" value="Edit Member">
                    </div>
                    <div class="add_form">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="field">
                                    <label for="first_name">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name', $user->first_name) }}" placeholder="Darrell">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="field">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" placeholder="Steward">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="field">
                                    <label for="user_name">User Name</label>
                                    <input type="text" class="form-control" id="user_name" name="name" value="{{ old('name', $user->name) }}" placeholder="Steward">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="field drop_down">
                                    <label for="role">User Role</label>
                                    <select class="form-control" name="role" id="role">
                                        <option value="" disabled>Select User Role</option>
                                        <option value="user_interface" {{ old('role', $user->role) == 'user_interface' ? 'selected' : '' }}>User Interface</option>
                                        <option value="consultant_interface" {{ old('role', $user->role) == 'consultant_interface' ? 'selected' : '' }}>Consultant Interface</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field drop_down">
                                    <label for="department">Select Department</label>
                                    <select class="form-control" name="department" id="department">
                                        <option value="" disabled>Select Department</option>
                                        @foreach($alldepartments as $department)
                                            <option value="{{ $department->id }}" {{ old('department', $user->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="field drop_down">
                                    <label for="Ranks">Select Ranks</label>
                                    <select class="form-control" name="rank" id="Ranks">
                                        <option value="" disabled selected>Select Ranks</option>
                                        <!-- Enlisted Ranks -->
                                        <option value="E1" {{ old('rank', $user->rank) == 'E1' ? 'selected' : '' }}>E1</option>
                                        <option value="E2" {{ old('rank', $user->rank) == 'E2' ? 'selected' : '' }}>E2</option>
                                        <option value="E3" {{ old('rank', $user->rank) == 'E3' ? 'selected' : '' }}>E3</option>
                                        <option value="E4" {{ old('rank', $user->rank) == 'E4' ? 'selected' : '' }}>E4</option>
                                        <option value="E5" {{ old('rank', $user->rank) == 'E5' ? 'selected' : '' }}>E5</option>
                                        <option value="E6" {{ old('rank', $user->rank) == 'E6' ? 'selected' : '' }}>E6</option>
                                        <option value="E7" {{ old('rank', $user->rank) == 'E7' ? 'selected' : '' }}>E7</option>
                                        <option value="E8" {{ old('rank', $user->rank) == 'E8' ? 'selected' : '' }}>E8</option>
                                        <option value="E9" {{ old('rank', $user->rank) == 'E9' ? 'selected' : '' }}>E9</option>
                                        <!-- Officer Ranks -->
                                        <option value="O1" {{ old('rank', $user->rank) == 'O1' ? 'selected' : '' }}>O1</option>
                                        <option value="O2" {{ old('rank', $user->rank) == 'O2' ? 'selected' : '' }}>O2</option>
                                        <option value="O3" {{ old('rank', $user->rank) == 'O3' ? 'selected' : '' }}>O3</option>
                                        <option value="O4" {{ old('rank', $user->rank) == 'O4' ? 'selected' : '' }}>O4</option>
                                        <option value="O5" {{ old('rank', $user->rank) == 'O5' ? 'selected' : '' }}>O5</option>
                                        <option value="O6" {{ old('rank', $user->rank) == 'O6' ? 'selected' : '' }}>O6</option>
                                        <option value="O7" {{ old('rank', $user->rank) == 'O7' ? 'selected' : '' }}>O7</option>
                                        <option value="O8" {{ old('rank', $user->rank) == 'O8' ? 'selected' : '' }}>O8</option>
                                        <option value="O9" {{ old('rank', $user->rank) == 'O9' ? 'selected' : '' }}>O9</option>
                                        <option value="O10" {{ old('rank', $user->rank) == 'O10' ? 'selected' : '' }}>O10</option>
                                        <!-- Warrant Officer Ranks -->
                                        <option value="WO1" {{ old('rank', $user->rank) == 'WO1' ? 'selected' : '' }}>WO1</option>
                                        <option value="WO2" {{ old('rank', $user->rank) == 'WO2' ? 'selected' : '' }}>WO2</option>
                                        <option value="WO3" {{ old('rank', $user->rank) == 'WO3' ? 'selected' : '' }}>WO3</option>
                                        <option value="WO4" {{ old('rank', $user->rank) == 'WO4' ? 'selected' : '' }}>WO4</option>
                                        <option value="WO5" {{ old('rank', $user->rank) == 'WO5' ? 'selected' : '' }}>WO5</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="field drop_down">
                                    <label for="branchs">Select Branchs</label>
                                    <select class="form-control" name="branch" id="branchs">
                                        <option value="" disabled selected>Select Branchs</option>
                                        <option value="Army" {{ old('branch', $user->branch) == 'Army' ? 'selected' : '' }}>Army</option>
                                        <option value="Navy" {{ old('branch', $user->branch) == 'Navy' ? 'selected' : '' }}>Navy</option>
                                        <option value="Airforce" {{ old('branch', $user->branch) == 'Airforce' ? 'selected' : '' }}>Airforce</option>
                                        <option value="Marine" {{ old('branch', $user->branch) == 'Marine' ? 'selected' : '' }}>Marine</option>
                                        <option value="Costguard" {{ old('branch', $user->branch) == 'Costguard' ? 'selected' : '' }}>Costguard</option>
                                        <option value="Space Force" {{ old('branch', $user->branch) == 'Space Force' ? 'selected' : '' }}>Space Force</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="field">
                                    <label for="years_of_experience">Years Of Experience</label>
                                    <input type="number" class="form-control" id="years_of_experience" value="{{ old('years_of_experience', $user->years_of_experience) }}" name="years_of_experience" placeholder="Years Of Experience" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="field">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" readonly value="{{ old('email', $user->email) }}" placeholder="Darrell.steward345@gmail.com" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field">
                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number', $user->phone_number) }}" placeholder="+012 345 6789" autocomplete="off" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="........" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field">
                                    <label for="confirm_password">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="........" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field">
                                    <label class="switch">
                                        <input class="toggleButton" name="status" type="checkbox" {{ $user->status == 'active' ? 'checked' : '' }}>
                                        <span class="slider round"></span>
                                        <span class="text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</span>
                                    </label>
                                    <!-- <input type="submit" name="submit" class="btn_submit" value="Submit"> -->
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
@endsection
