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
                        <div class="inbox_area bg_shade">
                            <div class="top_opt">
                                <h2 class="sec_head ft_oswlad">Inbox</h2>
                                <a href="javascript:;" class="btn_custom add_member">New Message</a>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-3">
                                    <div class="inbox_sidebar">
                                        <ul>
                                            <li class="active">
                                                <a href="javascript:;">
                                                    <span class="txt">Inbox</span>
                                                    <span class="nbr">89</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="txt">Marked</span>
                                                    <span class="nbr">24</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="txt">Draft</span>
                                                    <span class="nbr">5</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="txt">Sent</span>
                                                    <span class="nbr">38</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:;">
                                                    <span class="txt">Trash</span>
                                                    <span class="nbr">0</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-12 col-md-9">
                                    <table class="dt_table table table-bordered table-hover dt-responsive">
                                        <thead>
                                            <tr>
                                                <th>Message</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            <tr>
                                                <td>
                                                    <div class="user_col">
                                                        <img class="thumb"
                                                            src="{{ asset('dashboard_assets/images/thumb.png') }}"
                                                            alt="">
                                                        Jhon Doe
                                                    </div>
                                                </td>
                                                <td>Your Order #224820998666029 has been Confirmed</td>
                                                <td>8:30 PM</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="user_col">
                                                        <img class="thumb"
                                                            src="{{ asset('dashboard_assets/images/thumb_1.png') }}"
                                                            alt="">
                                                        Jhon Doe
                                                    </div>
                                                </td>
                                                <td>Congratulations on your subscription</td>
                                                <td>8:30 PM</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="user_col">
                                                        <img class="thumb"
                                                            src="{{ asset('dashboard_assets/images/thumb_2.png') }}"
                                                            alt="">
                                                        Jhon Doe
                                                    </div>
                                                </td>
                                                <td>Welcome, John Doe</td>
                                                <td>8:30 PM</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="user_col">
                                                        <img class="thumb"
                                                            src="{{ asset('dashboard_assets/images/thumb_3.png') }}"
                                                            alt="">
                                                        Jhon Doe
                                                    </div>
                                                </td>
                                                <td>Your Order #224820998666029 has been Confirmed</td>
                                                <td>8:30 PM</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="user_col">
                                                        <img class="thumb"
                                                            src="{{ asset('dashboard_assets/images/thumb_4.png') }}"
                                                            alt="">
                                                        Jhon Doe
                                                    </div>
                                                </td>
                                                <td>Your Order #224820998666029 has been Confirmed</td>
                                                <td>8:30 PM</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="user_col">
                                                        <img class="thumb"
                                                            src="{{ asset('dashboard_assets/images/thumb_5.png') }}"
                                                            alt="">
                                                        Jhon Doe
                                                    </div>
                                                </td>
                                                <td>Congratulations on your subscription</td>
                                                <td>8:30 PM</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="user_col">
                                                        <img class="thumb"
                                                            src="{{ asset('dashboard_assets/images/thumb_6.png') }}"
                                                            alt="">
                                                        Jhon Doe
                                                    </div>
                                                </td>
                                                <td>Welcome, John Doe</td>
                                                <td>8:30 PM</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="user_col">
                                                        <img class="thumb"
                                                            src="{{ asset('dashboard_assets/images/thumb_7.png') }}"
                                                            alt="">
                                                        Jhon Doe
                                                    </div>
                                                </td>
                                                <td>Congratulations on your subscription</td>
                                                <td>8:30 PM</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="user_col">
                                                        <img class="thumb"
                                                            src="{{ asset('dashboard_assets/images/thumb_8.png') }}"
                                                            alt="">
                                                        Jhon Doe
                                                    </div>
                                                </td>
                                                <td>Congratulations on your subscription</td>
                                                <td>8:30 PM</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="user_col">
                                                        <img class="thumb"
                                                            src="{{ asset('dashboard_assets/images/thumb_9.png') }}"
                                                            alt="">
                                                        Jhon Doe
                                                    </div>
                                                </td>
                                                <td>Your Order #224820998666029 has been Confirmed</td>
                                                <td>8:30 PM</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="user_col">
                                                        <img class="thumb"
                                                            src="{{ asset('dashboard_assets/images/thumb.png') }}"
                                                            alt="">
                                                        Jhon Doe
                                                    </div>
                                                </td>
                                                <td>Your Order #224820998666029 has been Confirmed</td>
                                                <td>8:30 PM</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="user_col">
                                                        <img class="thumb"
                                                            src="{{ asset('dashboard_assets/images/thumb_1.png') }}"
                                                            alt="">
                                                        Jhon Doe
                                                    </div>
                                                </td>
                                                <td>Congratulations on your subscription</td>
                                                <td>8:30 PM</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="user_col">
                                                        <img class="thumb"
                                                            src="{{ asset('dashboard_assets/images/thumb_2.png') }}"
                                                            alt="">
                                                        Jhon Doe
                                                    </div>
                                                </td>
                                                <td>Welcome, John Doe</td>
                                                <td>8:30 PM</td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="user_col">
                                                        <img class="thumb"
                                                            src="{{ asset('dashboard_assets/images/thumb_3.png') }}"
                                                            alt="">
                                                        Jhon Doe
                                                    </div>
                                                </td>
                                                <td>Your Order #224820998666029 has been Confirmed</td>
                                                <td>8:30 PM</td>
                                            </tr>


                                        </tbody>

                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection
