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
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="col-12 col-md-6">
                                    <div class="chart_box round_box">
                                        <h3>1.3K <span class="percent"><span class="icon"><img src="{{asset('dashboard_assets/images/up_arrow.png')}}" alt=""></span>2.2%</span></h3>
                                        <p>Daily appointments</p>
                                        <div id="pie-chart"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="chart_box bar_box">
                                        <h3><sup>$</sup>2,420 <span class="percent"><span class="icon"><img src="{{asset('dashboard_assets/images/up_arrow.png')}}" alt=""></span>2.6%</span></h3>
                                        <p>Average Daily Subscription</p>
                                        <div id="bar-chart"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-24">
                                <div class="col-12 col-md-6">
                                    <div class="chart_box pg_box">
                                        <h3>1,836 <span class="percent down"><span class="icon"><img src="{{asset('dashboard_assets/images/up_arrow.png')}}" alt=""></span>2.2%</span></h3>
                                        <p>Orders This Month</p>
                                        <div class="pg_bar">
                                            <div class="info">
                                                <h4>1,048 to Goal</h4>
                                                <p>62%</p>
                                            </div>
                                            <div class="meter">
                                                <span data-progress="62" style="width:0;"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="chart_box hero_box">
                                        <h3>6.3K</h3>
                                        <p>New Members This Month</p>
                                        <div class="heros">
                                            <h4>Today's Heores</h4>
                                            <img src="{{asset('dashboard_assets/images/hero.png')}}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="chart_box graph_box">
                                <h3>Subscription This Months</h3>
                                <p>Users from all department</p>
                                <h3><sup>$</sup>14,094</h3>
                                <p>Another $48,346 to Goal</p>
                                <div id="line-chart"></div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-24">
                        <div class="col-12 col-md-8">
                            <div class="announce_box bg_shade">
                                <div class="top_opt">
                                    <h2 class="sec_head ft_oswlad">Announcement</h2>
                                    <a href="javascript:;" class="btn_custom add_announce">+</a>
                                </div>
                                <table class="dt_table table table-bordered table-hover dt-responsive">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>
                                            <img src="{{asset('dashboard_assets/images/doc_green.png')}}" alt="">
                                            Sed ut perspiciatis unde omnis
                                        </td>
                                        <td>33 - 19 - 1</td>
                                        <td><div class="status green">Active</div></td>
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
                                            <img src="{{asset('dashboard_assets/images/doc_green.png')}}" alt="">
                                            Sed ut perspiciatis unde omnis
                                        </td>
                                        <td>33 - 19 - 1</td>
                                        <td><div class="status green">Active</div></td>
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
                                            <img src="{{asset('dashboard_assets/images/doc_green.png')}}" alt="">
                                            Sed ut perspiciatis unde omnis
                                        </td>
                                        <td>33 - 19 - 1</td>
                                        <td><div class="status green">Active</div></td>
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
                                            <img src="{{asset('dashboard_assets/images/doc_green.png')}}" alt="">
                                            Sed ut perspiciatis unde omnis
                                        </td>
                                        <td>33 - 19 - 1</td>
                                        <td><div class="status red">Inactive</div></td>
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
                        <div class="col-12 col-md-4">
                            <div class="notify_box">
                                <div class="head_top">
                                    <h3>Notifications</h3>
                                    <a href="javascript:;" class="btn_go">
                                        <img src="{{asset('dashboard_assets/images/go_icon.png')}}" alt="">
                                    </a>
                                </div>
                                <div class="extract">
                                    <ul>
                                        <li>
                                            <a href="javascript:;">
                                                <h4>Sed Ut Perspiciatis Unde Omnis</h4>
                                                <p>Placed At 5:05 AM By <img class="thumb" src="{{asset('dashboard_assets/images/thumb.png')}}" alt=""></p>
                                                <h5>
                                                    <img src="{{asset('dashboard_assets/images/docs.png')}}" alt="">
                                                    Lorem Ipsum is simply
                                                </h5>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <h4>Sed Ut Perspiciatis Unde Omnis</h4>
                                                <p>Placed At 5:05 AM By <img class="thumb" src="{{asset('dashboard_assets/images/thumb_1.png')}}" alt=""></p>
                                                <h5>
                                                    <img src="{{asset('dashboard_assets/images/docs.png')}}" alt="">
                                                    Lorem Ipsum is simply
                                                </h5>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <h4>Sed Ut Perspiciatis Unde Omnis</h4>
                                                <p>Placed At 5:05 AM By <img class="thumb" src="{{asset('dashboard_assets/images/thumb_2.png')}}" alt=""></p>
                                                <h5>
                                                    <img src="{{asset('dashboard_assets/images/docs.png')}}" alt="">
                                                    Lorem Ipsum is simply
                                                </h5>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <h4>Sed Ut Perspiciatis Unde Omnis</h4>
                                                <p>Placed At 5:05 AM By <img class="thumb" src="{{asset('dashboard_assets/images/thumb_3.png')}}" alt=""></p>
                                                <h5>
                                                    <img src="{{asset('dashboard_assets/images/docs.png')}}" alt="">
                                                    Lorem Ipsum is simply
                                                </h5>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <h4>Sed Ut Perspiciatis Unde Omnis</h4>
                                                <p>Placed At 5:05 AM By <img class="thumb" src="{{asset('dashboard_assets/images/thumb_4.png')}}" alt=""></p>
                                                <h5>
                                                    <img src="{{asset('dashboard_assets/images/docs.png')}}" alt="">
                                                    Lorem Ipsum is simply
                                                </h5>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <h4>Sed Ut Perspiciatis Unde Omnis</h4>
                                                <p>Placed At 5:05 AM By <img class="thumb" src="{{asset('dashboard_assets/images/thumb_5.png')}}" alt=""></p>
                                                <h5>
                                                    <img src="{{asset('dashboard_assets/images/docs.png')}}" alt="">
                                                    Lorem Ipsum is simply
                                                </h5>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
