<div class="side_menu">
	<ul class="main-menu">
        <li class="menu-item {{ Request::routeIs('home') ? 'active' : '' }}">
            <a href="{{ route('home') }}" class="nav-link">Dashboard</a>
        </li>
        <li class="menu-item {{ Request::routeIs('members') ? 'active' : '' }}">
            <a href="{{ route('members') }}" class="nav-link">Members</a>
        </li>
        <li class="menu-item {{ Request::routeIs('departments') ? 'active' : '' }}">
            <a href="{{ route('departments') }}" class="nav-link">Departments</a>
        </li>
        <!-- <li class="menu-item {{ Request::routeIs('locations') ? 'active' : '' }}">
            <a href="{{ route('locations') }}" class="nav-link">Near by Locations</a>
        </li> -->
        <li class="menu-item {{ Request::routeIs('appointments') ? 'active' : '' }}">
            <a href="{{ route('appointments') }}" class="nav-link">Appointments</a>
        </li>
        <li class="menu-item {{ Request::routeIs('notifications') ? 'active' : '' }}">
            <a href="#" class="nav-link">Notifications</a>
        </li>
        <li class="menu-item {{ Request::routeIs('subscriptions') ? 'active' : '' }}">
            <a href="{{ route('subscriptions') }}" class="nav-link">Subscriptions</a>
        </li>
        <li class="menu-item {{ Request::routeIs('reports') ? 'active' : '' }}">
            <a href="{{ route('reports') }}" class="nav-link">Reports</a>
        </li>
        <li class="menu-item {{ Request::routeIs('invoices') ? 'active' : '' }}">
            <a href="{{ route('invoices') }}" class="nav-link">Invoices</a>
        </li>
        <li class="menu-item {{ Request::routeIs('inbox') ? 'active' : '' }}">
            <a href="{{ route('inbox') }}" class="nav-link">Inbox</a>
        </li>

        {{--		<li class="menu-item">--}}
{{--			<a href="{{route('home')}}" class="nav-link">Settings</a>--}}
{{--		</li>--}}
		<li class="menu-item">
			<a href="javascript:;" class="nav-link">
				<img src="{{asset('dashboard_assets/images/icon_logout.png')}}" alt="">
				Logout
			</a>
		</li>
	</ul>
</div>
