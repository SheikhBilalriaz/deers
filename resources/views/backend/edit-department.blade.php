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
                        <form action="{{ route('departments.edit.submit', $department->id) }}" method="post" class="form" autocomplete="off" id="add_departments">
                        @csrf
                                @method('POST')
                                <div class="top_add">
                                    <a href="{{route('departments')}}" class="btn_back">
                                        <img src="{{ asset('dashboard_assets/images/icon_left.png') }}" alt="">
                                    </a>
                                    <div class="ext">
                                        <h2 class="sec_head ft_oswlad">Edit Departments</h2>
                                        <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
                                    </div>
                                    <input type="submit" name="submit" class="btn_custom" value="Edit Department">
                                </div>
                                <div class="add_form">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="field">
                                                <label for="dept_name">Department Name</label>
                                                <input value="{{ $department->name }}" type="text" class="form-control" id="dept_name" name="name" placeholder="Department">
                                                @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="field drop_down">
                                                <label for="department">Select City</label>
                                                <select class="form-control" name="city" id="department">
                                                    <option value="no" disabled selected>Select</option>
                                                    <option value="New York" {{ $department->city == 'New York' ? 'selected' : '' }}>New York</option>
                                                    <option value="New Jersey" {{ $department->city == 'New Jersey' ? 'selected' : '' }}>New Jersey</option>
                                                    <option value="California" {{ $department->city == 'California' ? 'selected' : '' }}>California</option>
                                                </select>
                                                @error('city')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="field address">
                                                <label for="address">Address</label>
                                                <input value="{{ $department->address }}" type="text" class="form-control" id="address" name="address" placeholder="Complete address">
                                                @error('address')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="field">
                                                <label for="phone_number">Phone Number</label>
                                                <input value="{{ $department->phone }}" type="number" class="form-control" id="phone_number" name="phone" placeholder="+012 345 6789" autocomplete="off" required>
                                                @error('phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="field">
                                                <label for="email">Email</label>
                                                <input value="{{ $department->email }}" type="email" class="form-control" id="email" name="email" placeholder="Enter Email" autocomplete="off">
                                                @error('email')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="field d-flex">
                                                <p>Status</p>
                                                <label class="switch">
                                                    <input name="status" class="toggleButton" type="checkbox" {{ $department->status == 'on' ? 'checked' : '' }}>
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
@endsection
