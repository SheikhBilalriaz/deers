@extends('backend.partials.master')
@section('content')
    <script src="{{ asset('dashboard_assets/js/messages.js') }}"></script>
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
                                <a href="javascript:;" class="btn_custom add_member">New Message</a>
                                {{-- <div class="search_msg">
                                    <form action="">
                                        <div class="field">
                                            <input type="text" name="search_msg" class="form-control"
                                                placeholder="Search">
                                            <input type="submit" name="submit" class="btn_submit">
                                        </div>
                                    </form>
                                </div> --}}
                            </div>
                            <div class="row">
                                <div class="col-12 col-md-4">
                                    <div class="msg_sidebar">
                                        <div class="search_msg">
                                            <form action="">
                                                <div class="field">
                                                    <input type="text" name="search_msg" class="form-control"
                                                        placeholder="Search">
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
                                                            <img src="assets/images/thumb.png" alt="">
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
                                                            <span class="notif">
                                                                {{ $chat->unreadMessages->count() }}
                                                            </span>
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
                                                <h2><img src="assets/images/thumb.png" alt="">Jhon Doe</h2>
                                                <p class="green">Active</p>
                                            </div>
                                            <div class="email">
                                                <p>Email<br><a href="javascript:;">abcdxyz@gmail.com</a></p>
                                            </div>
                                        </div>
                                        <div class="msg_body">
                                            <div class="msg msg_from">
                                                <div class="info">
                                                    <h4>
                                                        <img src="assets/images/thumb.png" alt="">
                                                        <span class="ext">Jhon Doe</span>
                                                        <span class="time">2 min</span>
                                                    </h4>
                                                </div>
                                                <div class="txt">
                                                    Lorem Ipsum is simply dummy text of the printing and typesetting
                                                    industry.
                                                </div>
                                            </div>
                                            <div class="msg msg_to">
                                                <div class="info">
                                                    <h4>
                                                        <img src="assets/images/thumb_1.png" alt="">
                                                        <span class="ext">Jhon Doe</span>
                                                        <span class="time">2 min</span>
                                                    </h4>
                                                </div>
                                                <div class="txt">
                                                    Lorem Ipsum is simply dummy text of the printing.
                                                </div>
                                            </div>
                                            <div class="msg msg_from">
                                                <div class="info">
                                                    <h4>
                                                        <img src="assets/images/thumb.png" alt="">
                                                        <span class="ext">Jhon Doe</span>
                                                        <span class="time">2 min</span>
                                                    </h4>
                                                </div>
                                                <div class="txt">
                                                    Lorem Ipsum is simply dummy text
                                                </div>
                                            </div>
                                            <div class="msg msg_to">
                                                <div class="info">
                                                    <h4>
                                                        <img src="assets/images/thumb_1.png" alt="">
                                                        <span class="ext">Jhon Doe</span>
                                                        <span class="time">2 min</span>
                                                    </h4>
                                                </div>
                                                <div class="txt">
                                                    Lorem Ipsum is simply
                                                </div>
                                            </div>
                                            <div class="msg msg_from">
                                                <div class="info">
                                                    <h4>
                                                        <img src="assets/images/thumb.png" alt="">
                                                        <span class="ext">Jhon Doe</span>
                                                        <span class="time">2 min</span>
                                                    </h4>
                                                </div>
                                                <div class="txt">
                                                    Lorem Ipsum is simply dummy text of the printing and typesetting
                                                    industry.
                                                </div>
                                            </div>
                                            <div class="msg msg_to">
                                                <div class="info">
                                                    <h4>
                                                        <img src="assets/images/thumb_1.png" alt="">
                                                        <span class="ext">Jhon Doe</span>
                                                        <span class="time">2 min</span>
                                                    </h4>
                                                </div>
                                                <div class="txt">
                                                    Lorem Ipsum is simply dummy text of the printing.
                                                </div>
                                            </div>
                                            <div class="msg msg_from">
                                                <div class="info">
                                                    <h4>
                                                        <img src="assets/images/thumb.png" alt="">
                                                        <span class="ext">Jhon Doe</span>
                                                        <span class="time">2 min</span>
                                                    </h4>
                                                </div>
                                                <div class="txt">
                                                    Lorem Ipsum is simply dummy text
                                                </div>
                                            </div>
                                            <div class="msg msg_to">
                                                <div class="info">
                                                    <h4>
                                                        <img src="assets/images/thumb_1.png" alt="">
                                                        <span class="ext">Jhon Doe</span>
                                                        <span class="time">2 min</span>
                                                    </h4>
                                                </div>
                                                <div class="txt">
                                                    Lorem Ipsum is simply
                                                </div>
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
    <script>
        var getMessagesRoute =
            "{{ route('admin.get-messages', ['conversation_id' => ':conversation_id', 'page' => ':page']) }}";
    </script>
@endsection
