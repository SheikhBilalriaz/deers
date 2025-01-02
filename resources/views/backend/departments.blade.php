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

                @if (session('success'))
                    <div class="mb-5">
                        <span class="alert alert-success" role="alert">
                            <strong> {{ session('success') }}</strong>
                        </span>
                    </div>
                @endif
                    @if (session('error'))
                        <div class="mb-5">
                            <span class="alert alert-danger" role="alert">
                                <strong> {{ session('error') }}</strong>
                            </span>
                        </div>
                    @endif
                <div class="dept_area bg_shade">

                    <div class="top_opt">
                        <h2 class="sec_head ft_oswlad">Departments</h2>
                        <a href="{{route('add_departments')}}" class="btn_custom add_member">Add New Department</a>
                    </div>

                    <table class="dt_table table table-bordered table-hover dt-responsive">
                        <thead>
                            <tr>
                                <th>Departments Name</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>

                            @foreach($all_data as $key => $all_departments)
                                <tr>
                                    <td>
                                        <div class="user_col">
                                            {{--  <img class="thumb" src="{{asset('dashboard_assets/images/civilian_dept.png')}}" alt="">--}}
                                            {{$all_departments->name}}
                                        </div>
                                    </td>


                                    <td>{{$all_departments->created_at->format('Y-m-d')}}</td>
                                    <td>
                                        @if($all_departments->status === 'on')
                                            <div class="status green">Active</div>
                                        @elseif($all_departments->status === 'inactive')
                                            <div class="status red">In Active</div>
                                        @endif

                                    </td>
                                    <td>
                                        <a href="javascript:;" class="action_link">
                                            <img src="{{asset('dashboard_assets/images/icon_action.png')}}" alt="">
                                        </a>
                                        <div class="actions">                                            
                                            <a href="{{ route('edit_departments', ['department' => $all_departments->id]) }}" class="edit">
                                                <span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>Edit
                                            </a>
                                            <form action="{{ route('departments.destroy', ['department' => $all_departments->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete" style="background:none; border:none; cursor:pointer;">
                                                    <span class="icon"><i class="fa-solid fa-trash"></i></span>Delete
                                                </button>
                                            </form>                                        
                                        </div>
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
