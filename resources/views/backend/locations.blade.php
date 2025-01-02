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
                <div class="locat_area bg_shade">
                    <div class="top_opt">
                        <h2 class="sec_head ft_oswlad">Near By Locations</h2>
                        <a href="{{route('add_location')}}" class="btn_custom add_member">Add New Location</a>
                    </div>
                    <table class="dt_table table table-bordered table-hover dt-responsive">
                        <thead>
                        <tr>
                            <th>Departments Name</th>
                            <th>Created Date</th>
                            <th>Loactions</th>
                            <th>ZIP Code</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>

                        <tr>
                            <td>
                                <div class="user_col">
                                    <img class="thumb" src="{{asset('dashboard_assets/images/verify_dept.png')}}" alt="">
                                    Verification Department
                                </div>
                            </td>
                            <td>356 Bay Ave. Warren, MI 48089</td>
                            <td>48089</td>
                            <td>33 - 19 - 1</td>
                            <td>
                                <div class="status green">Active</div>
                            </td>
                            <td>
                                <a href="javascript:;" class="action_link">
                                    <img src="{{asset('dashboard_assets/images/icon_action.png')}}" alt="">
                                </a>
                                <div class="actions">
                                    <a href="javascript:;" class="viiew"><span class="icon"><i class="fa-solid fa-eye"></i></span>View</a>
                                    <a href="javascript:;" class="edit"><span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>Edit</a>
                                    <a href="javascript:;" class="delete"><span class="icon"><i class="fa-solid fa-trash"></i></span>Delete</a>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="user_col">
                                    <img class="thumb" src="{{asset('dashboard_assets/images/civilian_dept.png')}}  " alt="">
                                    Civilian Pay Department
                                </div>
                            </td>
                            <td>356 Bay Ave. Warren, MI 48089</td>
                            <td>48089</td>
                            <td>33 - 19 - 1</td>
                            <td>
                                <div class="status green">Active</div>
                            </td>
                            <td>
                                <a href="javascript:;" class="action_link">
                                    <img src="{{asset('dashboard_assets/images/icon_action.png')}}" alt="">
                                </a>
                                <div class="actions">
                                    <a href="javascript:;" class="viiew"><span class="icon"><i class="fa-solid fa-eye"></i></span>View</a>
                                    <a href="javascript:;" class="edit"><span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>Edit</a>
                                    <a href="javascript:;" class="delete"><span class="icon"><i class="fa-solid fa-trash"></i></span>Delete</a>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="user_col">
                                    <img class="thumb" src="{{asset('dashboard_assets/images/health_dept.png')}}" alt="">
                                    Health Department
                                </div>
                            </td>
                            <td>356 Bay Ave. Warren, MI 48089</td>
                            <td>48089</td>
                            <td>33 - 19 - 1</td>
                            <td>
                                <div class="status green">Active</div>
                            </td>
                            <td>
                                <a href="javascript:;" class="action_link">
                                    <img src="{{asset('dashboard_assets/images/icon_action.png')}}" alt="">
                                </a>
                                <div class="actions">
                                    <a href="javascript:;" class="viiew"><span class="icon"><i class="fa-solid fa-eye"></i></span>View</a>
                                    <a href="javascript:;" class="edit"><span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>Edit</a>
                                    <a href="javascript:;" class="delete"><span class="icon"><i class="fa-solid fa-trash"></i></span>Delete</a>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="user_col">
                                    <img class="thumb" src="{{asset('dashboard_assets/images/defense_dept.png')}}" alt="">
                                    Defense Department
                                </div>
                            </td>
                            <td>356 Bay Ave. Warren, MI 48089</td>
                            <td>48089</td>
                            <td>33 - 19 - 1</td>
                            <td>
                                <div class="status green">Active</div>
                            </td>
                            <td>
                                <a href="javascript:;" class="action_link">
                                    <img src="{{asset('dashboard_assets/images/icon_action.png')}}" alt="">
                                </a>
                                <div class="actions">
                                    <a href="javascript:;" class="viiew"><span class="icon"><i class="fa-solid fa-eye"></i></span>View</a>
                                    <a href="javascript:;" class="edit"><span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>Edit</a>
                                    <a href="javascript:;" class="delete"><span class="icon"><i class="fa-solid fa-trash"></i></span>Delete</a>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="user_col">
                                    <img class="thumb" src="{{asset('dashboard_assets/images/verify_dept.png')}}" alt="">
                                    Verification Department
                                </div>
                            </td>
                            <td>356 Bay Ave. Warren, MI 48089</td>
                            <td>48089</td>
                            <td>33 - 19 - 1</td>
                            <td>
                                <div class="status green">Active</div>
                            </td>
                            <td>
                                <a href="javascript:;" class="action_link">
                                    <img src="{{asset('dashboard_assets/images/icon_action.png')}}" alt="">
                                </a>
                                <div class="actions">
                                    <a href="javascript:;" class="viiew"><span class="icon"><i class="fa-solid fa-eye"></i></span>View</a>
                                    <a href="javascript:;" class="edit"><span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>Edit</a>
                                    <a href="javascript:;" class="delete"><span class="icon"><i class="fa-solid fa-trash"></i></span>Delete</a>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="user_col">
                                    <img class="thumb" src="{{asset('dashboard_assets/images/civilian_dept.png')}}" alt="">
                                    Civilian Pay Department
                                </div>
                            </td>
                            <td>356 Bay Ave. Warren, MI 48089</td>
                            <td>48089</td>
                            <td>33 - 19 - 1</td>
                            <td>
                                <div class="status green">Active</div>
                            </td>
                            <td>
                                <a href="javascript:;" class="action_link">
                                    <img src="{{asset('dashboard_assets/images/icon_action.png')}}" alt="">
                                </a>
                                <div class="actions">
                                    <a href="javascript:;" class="viiew"><span class="icon"><i class="fa-solid fa-eye"></i></span>View</a>
                                    <a href="javascript:;" class="edit"><span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>Edit</a>
                                    <a href="javascript:;" class="delete"><span class="icon"><i class="fa-solid fa-trash"></i></span>Delete</a>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="user_col">
                                    <img class="thumb" src="{{asset('dashboard_assets/images/health_dept.png')}}" alt="">
                                    Health Department
                                </div>
                            </td>
                            <td>356 Bay Ave. Warren, MI 48089</td>
                            <td>48089</td>
                            <td>33 - 19 - 1</td>
                            <td>
                                <div class="status green">Active</div>
                            </td>
                            <td>
                                <a href="javascript:;" class="action_link">
                                    <img src="{{asset('dashboard_assets/images/icon_action.png')}}" alt="">
                                </a>
                                <div class="actions">
                                    <a href="javascript:;" class="viiew"><span class="icon"><i class="fa-solid fa-eye"></i></span>View</a>
                                    <a href="javascript:;" class="edit"><span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>Edit</a>
                                    <a href="javascript:;" class="delete"><span class="icon"><i class="fa-solid fa-trash"></i></span>Delete</a>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="user_col">
                                    <img class="thumb" src="{{asset('dashboard_assets/images/defense_dept.png')}}" alt="">
                                    Defense Department
                                </div>
                            </td>
                            <td>356 Bay Ave. Warren, MI 48089</td>
                            <td>48089</td>
                            <td>33 - 19 - 1</td>
                            <td>
                                <div class="status green">Active</div>
                            </td>
                            <td>
                                <a href="javascript:;" class="action_link">
                                    <img src="{{asset('dashboard_assets/images/icon_action.png')}}" alt="">
                                </a>
                                <div class="actions">
                                    <a href="javascript:;" class="viiew"><span class="icon"><i class="fa-solid fa-eye"></i></span>View</a>
                                    <a href="javascript:;" class="edit"><span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>Edit</a>
                                    <a href="javascript:;" class="delete"><span class="icon"><i class="fa-solid fa-trash"></i></span>Delete</a>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <div class="user_col">
                                    <img class="thumb" src="{{asset('dashboard_assets/images/verify_dept.png')}}" alt="">
                                    Verification Department
                                </div>
                            </td>
                            <td>356 Bay Ave. Warren, MI 48089</td>
                            <td>48089</td>
                            <td>33 - 19 - 1</td>
                            <td>
                                <div class="status green">Active</div>
                            </td>
                            <td>
                                <a href="javascript:;" class="action_link">
                                    <img src="{{asset('dashboard_assets/images/icon_action.png')}}" alt="">
                                </a>
                                <div class="actions">
                                    <a href="javascript:;" class="viiew"><span class="icon"><i class="fa-solid fa-eye"></i></span>View</a>
                                    <a href="javascript:;" class="edit"><span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>Edit</a>
                                    <a href="javascript:;" class="delete"><span class="icon"><i class="fa-solid fa-trash"></i></span>Delete</a>
                                </div>
                            </td>
                        </tr>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
@endsection
