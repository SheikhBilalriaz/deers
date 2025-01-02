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
                <div class="member_area bg_shade">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="top_opt">
                        <h2 class="sec_head ft_oswlad">Members</h2>
                        <a href="{{route('add_members')}}" class="btn_custom add_member">Add New Member</a>
                    </div>
                    <table class="dt_table table table-bordered table-hover dt-responsive">
                        <thead>
                        <tr>
                            <th>Member</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Created Date</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($all_users as $member)
                            @if($member->role != 'admin')
                                <tr>
                                    <td>
                                        <div class="user_col">
                                            <img class="thumb" src="{{asset('dashboard_assets/images/thumb.png')}}" alt="">
                                            {{$member->name }}
                                        </div>
                                    </td>
                                    <td>{{$member->email }}</td>
                                    <td>
                                        @if (isset($member['department']))
                                            {{ $member['department']->name }}
                                        @else
                                            No Department
                                        @endif
                                    </td>
                                    <td>{{$member->created_at->format('Y-m-d') }}</td>
                                    <td>
                                        @if($member->status === 'active')
                                            <div class="status green">Active</div>
                                        @elseif($member->status === 'inactive')
                                            <div class="status red">In Active</div>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="javascript:;" class="action_link">
                                            <img src="{{asset('dashboard_assets/images/icon_action.png')}}" alt="">
                                        </a>
                                        <div class="actions">
                                            <!-- <a href="javascript:;" class="viiew"><span class="icon"><i class="fa-solid fa-eye"></i></span>View</a> -->
                                            <a href="{{ route('edit_members', ['user' => $member->id]) }}" class="edit"><span class="icon"><i class="fa-solid fa-pen-to-square"></i></span>Edit</a>
                                            
                                            <!-- <a href="javascript:;" class="delete"><span class="icon"><i class="fa-solid fa-trash"></i></span>Delete</a> -->
                                            <form action="{{ route('members.destroy', ['user' => $member->id]) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="delete" style="background:none; border:none; cursor:pointer;">
                                                    <span class="icon"><i class="fa-solid fa-trash"></i></span>Delete
                                                </button>
                                            </form>  
                                        </div>
                                    </td>                           
                                </tr>
                            @endif
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
