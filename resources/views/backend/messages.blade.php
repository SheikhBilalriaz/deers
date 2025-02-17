@extends('backend.partials.master')
@section('content')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <script src="{{ asset('dashboard_assets/js/messages.js') }}"></script>
    <style>
        .loader {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 999;
            display: none;
            padding-top: 50%;
            padding-left: 50%;
        }

        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
    <div class="content">
        <section class="secDashboard">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-md-2">
                        @include('backend.partials.sidebar')
                    </div>
                    <div class="col-12 col-md-10">
                        <div class="msg_area bg_shade">
                            <div class="top_opt">
                                <h2 class="sec_head ft_oswlad">Messages</h2>
                                <a class="btn btn_custom add_member" data-toggle="modal" data-target="#addMemberModal">
                                    New Message
                                </a>
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="msg_sidebar">
                                        <div class="search_msg">
                                            <form action="">
                                                <div class="field">
                                                    <input type="text" name="search_msg" class="form-control"
                                                        placeholder="Search" id="search_msg">
                                                    <input type="submit" name="submit" class="btn_submit">
                                                </div>
                                            </form>
                                        </div>
                                        <ul class="conversations">
                                            @foreach ($chats as $index => $chat)
                                                @php
                                                    $participants = $chat->participants->map(function ($participant) {
                                                        return [
                                                            'name' => $participant->user->name ?? 'Unknown',
                                                            'email' => $participant->user->email ?? 'No email',
                                                        ];
                                                    });

                                                    $participantNames = $participants->pluck('name')->toArray();
                                                    $participantEmails = $participants->pluck('email')->toArray();
                                                    $count = count($participants);
                                                @endphp
                                                <li class="{{ $index == 0 ? 'active' : '' }}"
                                                    id="{{ 'chat-' . $chat->id }}">
                                                    <a href="javascript:;">
                                                        <div class="info">
                                                            <img src="dashboard_assets/images/thumb.png" alt="">
                                                            <h4>
                                                                @if ($count == 1)
                                                                    {{ $participantNames[0] }}
                                                                @elseif($count == 2)
                                                                    {{ implode(' & ', $participantNames) }}
                                                                @elseif($count > 2)
                                                                    {{ $participantNames[0] }}, {{ $participantNames[1] }} &
                                                                    more...
                                                                @else
                                                                    No participants
                                                                @endif
                                                            </h4>
                                                            <p>
                                                                @if ($count == 1)
                                                                    {{ $participantEmails[0] }}
                                                                @elseif($count == 2)
                                                                    {{ implode(' & ', $participantEmails) }}
                                                                @elseif($count > 2)
                                                                    {{ $participantEmails[0] }},
                                                                    {{ $participantEmails[1] }}
                                                                    & more...
                                                                @else
                                                                    No participants
                                                                @endif
                                                            </p>
                                                        </div>
                                                        <div class="time_ago">
                                                            <span class="time">
                                                                {{ $chat->lastMessage->created_at->diffForHumans() }}
                                                            </span>
                                                            @if ($chat->unreadMessages->count() > 0)
                                                                <span class="notif">
                                                                    {{ $chat->unreadMessages->count() }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="msg_box">
                                        <div class="msg_head">
                                            <div class="user_info">
                                                <h2>
                                                    <img src="dashboard_assets/images/thumb.png" alt="">
                                                    <span id="receiver_name"></span>
                                                </h2>
                                                <p class="green">Active</p>
                                            </div>
                                            <div class="email">
                                                <p>
                                                    Email
                                                    <br>
                                                    <a href="javascript:;" id="receiver_email"></a>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="msg_body chat-container" style="position: relative;">
                                            <div class="loader">
                                                <div class="spinner"></div>
                                            </div>
                                        </div>
                                        <div class="msg_input">
                                            <form action="" class="form">
                                                <div class="field">
                                                    <textarea class="form-control" name="typing" id="typing" placeholder="Type a message" required></textarea>
                                                </div>
                                                <div class="btn_type">
                                                    <div class="upload">
                                                        <input type="file" class="file_upload" name="file_upload">
                                                        <button class="btn_upload" type="button">
                                                            <img src="assets/images/btn_upload.png" alt="">
                                                        </button>
                                                    </div>
                                                    <div class="btn_form">
                                                        <input type="submit" name="submit" class="btn_send"
                                                            value="Send">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="addMemberModal" tabindex="-1" role="dialog" aria-labelledby="addMemberModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="field">
                            <input type="text" name="search_msg" class="form-control" placeholder="Search"
                                id="search_msg">
                        </div>
                    </form>
                    <ul>
                        @foreach ($users as $index => $user)
                            <li id="{{ 'user-' . $user->id }}">
                                <a>
                                    <div class="info">
                                        <img src="dashboard_assets/images/thumb.png" alt="">
                                        <h4>{{ $user->name }}</h4>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script>
        var getMessagesRoute =
            "{{ route('admin.get-messages', ['conversation_id' => ':conversation_id', 'page' => ':page']) }}";
        var userId = "{{ Auth::user()->id }}";
    </script>
@endsection
