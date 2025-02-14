<header id="masthead" class="header">
    <div class="container-fluid">
        <nav class="navbar navbar-light">
            <div class="navbar-brand">
                <a href="javascript:;">
                    <img src="{{ asset('dashboard_assets/images/logo.png') }}" alt="">
                </a>
            </div>
            <div class="navbar-content">
                <div class="search_form">
                    <form action="">
                        <div class="field">
                            <input type="text" class="form-control" name="search" placeholder="Search">
                            <input type="submit" name="submit" value="Search" class="btn-submit">
                        </div>
                    </form>
                </div>
                <div class="notification">
                    <a href="javascript:;" class="notify_link">
                        <img src="{{ asset('dashboard_assets/images/icon-notify.png') }}" alt="">
                    </a>
                    <div class="notify_bar">
                        <ul>
                            <li>
                                <p>You have 4 new notification <a href="javascript:;">View All</a></p>
                            </li>
                            <li>
                                <a href="javascript:;" class="notify">
                                    <span class="icon">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </span>
                                    <span class="title">Lorem Ipsum</span>
                                    <span class="txt">Lorem Ipsum Dolor Iot</span>
                                    <span class="time_ago">28m ago</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="notify">
                                    <span class="icon">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </span>
                                    <span class="title">Lorem Ipsum</span>
                                    <span class="txt">Lorem Ipsum Dolor Iot</span>
                                    <span class="time_ago">28m ago</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="notify">
                                    <span class="icon">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </span>
                                    <span class="title">Lorem Ipsum</span>
                                    <span class="txt">Lorem Ipsum Dolor Iot</span>
                                    <span class="time_ago">28m ago</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="notify">
                                    <span class="icon">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </span>
                                    <span class="title">Lorem Ipsum</span>
                                    <span class="txt">Lorem Ipsum Dolor Iot</span>
                                    <span class="time_ago">28m ago</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="show_all">Show all notifications</a>
                            </li>
                        </ul>

                    </div>
                </div>
                <div class="profile">
                    <a href="javascript:;" class="user_link">
                        <img class="thumb" src="{{ asset('dashboard_assets/images/user.png') }}" alt="">
                        <span class="txt">Super Admin</span>
                        <span class="icon">
                            <img src="{{ asset('dashboard_assets/images/down_arrow.png') }}" alt="">
                        </span>
                    </a>
                    <div class="profile_bar">
                        <ul>
                            <li>
                                <a href="javascript:;">
                                    <span class="icon"><i class="fa-regular fa-user"></i></span>
                                    <span class="txt">My Profile</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span class="icon"><i class="fa-solid fa-gear"></i></span>
                                    <span class="txt">Account Settings</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;">
                                    <span class="icon"><i class="fa-solid fa-circle-info"></i></span>
                                    <span class="txt">Need Help?</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                                    <span class="icon"><i class="fa-solid fa-right-from-bracket"></i></span>
                                    <span class="txt">Sign Out</span>
                                    <form method="post" id="logout-form" action="{{ route('logout') }}">
                                        @csrf
                                    </form>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</header>
