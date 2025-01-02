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
                    <div class="subscrip_area bg_shade">
                        <div class="top_opt">
                            <h2 class="sec_head ft_oswlad">Subscriptions</h2>
                            <a href="javascript:;" class="btn_custom add_member"><img src="{{asset('dashboard_assets/images/export.png')}}" alt="">Export Report</a>
                        </div>
                        <table class="dt_table table table-bordered table-hover dt-responsive">
                            <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Billing</th>
                                <th>Package</th>
                                <th>Created Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                            </thead>

                            <tbody>

                            <tr>
                                <td>
                                    <div class="user_col">
                                        <img class="thumb" src="{{asset('dashboard_assets/images/thumb.png')}}" alt="">
                                        Lorem ipsum dolor sit amet
                                    </div>
                                </td>
                                <td>Auto-Debit</td>
                                <td>Minthly Plan</td>
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
                                        <img class="thumb" src="{{asset('dashboard_assets/images/thumb_4.png')}}" alt="">
                                        Lorem ipsum dolor sit amet
                                    </div>
                                </td>
                                <td>Auto-Debit Pay</td>
                                <td>Minthly Plan</td>
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
                                        <img class="thumb" src="{{asset('dashboard_assets/images/thumb_5.png')}}" alt="">
                                        Lorem ipsum dolor sit amet
                                    </div>
                                </td>
                                <td>Auto-Debit Pay</td>
                                <td>Minthly Plan</td>
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
                                        <img class="thumb" src="{{asset('dashboard_assets/images/thumb_6.png')}}" alt="">
                                        Lorem ipsum dolor sit amet
                                    </div>
                                </td>
                                <td>Auto-Debit</td>
                                <td>Minthly Plan</td>
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
                                        <img class="thumb" src="{{asset('dashboard_assets/images/thumb_7.png')}}" alt="">
                                        Lorem ipsum dolor sit amet
                                    </div>
                                </td>
                                <td>Auto-Debit Pay</td>
                                <td>Minthly Plan</td>
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
                                        <img class="thumb" src="{{asset('dashboard_assets/images/thumb_8.png')}}" alt="">
                                        Lorem ipsum dolor sit amet
                                    </div>
                                </td>
                                <td>Auto-Debit</td>
                                <td>Minthly Plan</td>
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
                                        <img class="thumb" src="{{asset('dashboard_assets/images/thumb_9.png')}}" alt="">
                                        Lorem ipsum dolor sit amet
                                    </div>
                                </td>
                                <td>Auto-Debit</td>
                                <td>Minthly Plan</td>
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
                                        <img class="thumb" src="{{asset('dashboard_assets/images/thumb_10.png')}}" alt="">
                                        Lorem ipsum dolor sit amet
                                    </div>
                                </td>
                                <td>Auto-Debit</td>
                                <td>Minthly Plan</td>
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
