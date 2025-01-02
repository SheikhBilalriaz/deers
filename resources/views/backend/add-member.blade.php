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
                <form action="{{ route('add_members_submit') }}" method="post" class="form" autocomplete="off">
                @csrf  <!-- CSRF Token -->

                    <div class="top_add">
                        <a href="{{route('members')}}" class="btn_back">
                            <img src="{{ asset('dashboard_assets/images/icon_left.png') }}" alt="">
                        </a>
                        <div class="ext">
                            <h2 class="sec_head ft_oswlad">Add New Members</h2>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
                        </div>
                        <a href="javascript:;" class="btn_custom">Add New Member</a>
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
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ old('first_name') }}" placeholder="Darrell">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="field">
                                    <label for="last_name">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name') }}" placeholder="Steward">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="field">
                                    <label for="user_name">User Name</label>
                                    <input type="text" class="form-control" id="user_name" name="name" value="{{ old('name') }}" placeholder="Steward">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="field drop_down">
                                    <label for="department">User Role</label>
                                    <select class="form-control" name="role" id="role">
                                        <option value="" disabled selected>Select User Role</option>
                                        <option value="user_interface" {{ old('role') == 'user_interface' ? 'selected' : '' }}>User Interface</option>
                                        <option value="consultant_interface" {{ old('role') == 'consultant_interface' ? 'selected' : '' }}>Consultant Interface</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field drop_down">
                                    <label for="department">Select Department</label>
                                    <select class="form-control" name="department" id="department">
                                        <option value="" disabled selected>Select Department</option>
                                        @foreach($alldepartments as $department)
                                            <option value="{{ $department->id }}" {{ old('department') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field drop_down">
                                    <label for="Ranks">Select Ranks</label>
                                    <select class="form-control" name="rank" id="Ranks">
                                        <option value="" disabled selected>Select Ranks</option>
                                        <!-- Enlisted Ranks -->
                                        <option value="E1">E1</option>
                                        <option value="E2">E2</option>
                                        <option value="E3">E3</option>
                                        <option value="E4">E4</option>
                                        <option value="E5">E5</option>
                                        <option value="E6">E6</option>
                                        <option value="E7">E7</option>
                                        <option value="E8">E8</option>
                                        <option value="E9">E9</option>
                                        <!-- Officer Ranks -->
                                        <option value="O1">O1</option>
                                        <option value="O2">O2</option>
                                        <option value="O3">O3</option>
                                        <option value="O4">O4</option>
                                        <option value="O5">O5</option>
                                        <option value="O6">O6</option>
                                        <option value="O7">O7</option>
                                        <option value="O8">O8</option>
                                        <option value="O9">O9</option>
                                        <option value="O10">O10</option>
                                        <!-- Warrant Officer Ranks -->
                                        <option value="WO1">WO1</option>
                                        <option value="WO2">WO2</option>
                                        <option value="WO3">WO3</option>
                                        <option value="WO4">WO4</option>
                                        <option value="WO5">WO5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="field drop_down">
                                    <label for="branchs">Select Branchs</label>
                                    <select class="form-control" name="branch" id="branchs">
                                        <option value="" disabled selected>Select Branchs</option>
                                        <option value="Army">Army</option>
                                        <option value="Navy">Navy</option>
                                        <option value="Airforce">Airforce</option>
                                        <option value="Marine">Marine</option>
                                        <option value="Costguard">Costguard</option>
                                        <option value="space force">Space Force</option>
                                    
                                        
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="field">
                                    <label for="years_of_experience">Years Of Experience</label>
                                    <input type="number" class="form-control" id="years_of_experience" name="years_of_experience" placeholder="Years Of Experience" autocomplete="off">
                                </div>
                            </div>
                            
                            <div class="col-6">
                                <div class="field">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Darrell.steward345@gmail.com" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="field">
                                    <label for="phone_number">Phone Number</label>
                                    <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ old('phone_number') }}" placeholder="+012 345 6789" autocomplete="off" required>
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
                                        <input class="toggleButton" type="checkbox" checked>
                                        <span class="slider round"></span>
                                        <span class="text">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</span>
                                    </label>
                                    <input type="submit" name="submit" class="btn_submit" value="Submit">
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
