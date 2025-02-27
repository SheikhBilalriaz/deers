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
        .chatListLoader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 10px auto;
        }

        .messageListLoader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 10px auto;
        }

        .userListLoader {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 10px auto;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .stacked-images {
            display: flex;
            align-items: center;
        }

        .stacked-images .profile-img {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            border: 2px solid #fff;
            margin-left: -10px;
        }

        .stacked-images .profile-img:first-child {
            margin-left: 0;
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
                                    <div class="msg_sidebar" id="chat_conversation_sidebar">
                                        <div class="search_msg">
                                            <form action="">
                                                <div class="field">
                                                    <input type="text" name="search_chat" class="form-control"
                                                        placeholder="Search" id="search_chat">
                                                    <input type="submit" name="submit" class="btn_submit">
                                                </div>
                                            </form>
                                        </div>
                                        <ul class="conversations"></ul>
                                        <div id="chatListLoader" class="chatListLoader" style="display: block;"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-8">
                                    <div class="msg_box">
                                        <div class="msg_head">
                                            <div class="user_info">
                                                <h2>
                                                    <span id="profile_images"></span>
                                                    <span id="receiver_name"></span>
                                                </h2>
                                                <p class="green">Active</p>
                                            </div>
                                            <div class="email">
                                                <p>Email
                                                <div id="receiver_email"></div>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="msg_body chat-container">
                                            <div class="messageListLoader" id="messageListLoader" style="display: none;">
                                            </div>
                                        </div>
                                        <div class="msg_input">
                                            <form class="form" id="send-message">
                                                @csrf
                                                <div class="field">
                                                    <textarea class="form-control" name="typing" id="typing" placeholder="Type a message"></textarea>
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
                    <h5 class="modal-title" id="addMemberModalLabel">Start New Conversation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="">
                        <div class="field">
                            <input type="text" name="search_user" class="form-control" placeholder="Search"
                                id="search_user">
                        </div>
                    </form>
                    <ul class="user-list"></ul>
                    <div id="userListLoader" class="userListLoader" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
