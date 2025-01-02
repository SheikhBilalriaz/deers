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
                    <div class="msg_area bg_shade">
                        <div class="top_opt">
                            <h2 class="sec_head ft_oswlad">Inbox</h2>
                            <div class="search_msg">
                                <form action="">
                                    <div class="field">
                                        <input type="text" name="search_msg" class="form-control" placeholder="Search">
                                        <input type="submit" name="submit" class="btn_submit">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="msg_sidebar">
                                    <div class="search_msg">
                                        <form action="">
                                            <div class="field">
                                                <input type="text" name="search_msg" class="form-control" placeholder="Search">
                                                <input type="submit" name="submit" class="btn_submit">
                                            </div>
                                        </form>
                                    </div>
                                    <ul>
                                        <li class="active">
                                            <a href="javascript:;">
                                                <div class="info">
                                                    <img src="assets/images/thumb.png" alt="">
                                                    <h4>Jhon Doe</h4>
                                                    <p>abcdxyz@gmail.com</p>
                                                </div>
                                                <div class="time_ago">
                                                    <span class="time">3hrs</span>
                                                    <span class="notif">2</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="info">
                                                    <img src="assets/images/thumb_1.png" alt="">
                                                    <h4>Jhon Doe</h4>
                                                    <p>abcdxyz@gmail.com</p>
                                                </div>
                                                <div class="time_ago">
                                                    <span class="time">3hrs</span>
                                                    <span class="notif">4</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="info">
                                                    <img src="assets/images/thumb_2.png" alt="">
                                                    <h4>Jhon Doe</h4>
                                                    <p>abcdxyz@gmail.com</p>
                                                </div>
                                                <div class="time_ago">
                                                    <span class="time">3hrs</span>
                                                    <span class="notif">1</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="info">
                                                    <img src="assets/images/thumb_3.png" alt="">
                                                    <h4>Jhon Doe</h4>
                                                    <p>abcdxyz@gmail.com</p>
                                                </div>
                                                <div class="time_ago">
                                                    <span class="time">3hrs</span>
                                                    <span class="notif">3</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="info">
                                                    <img src="assets/images/thumb_4.png" alt="">
                                                    <h4>Jhon Doe</h4>
                                                    <p>abcdxyz@gmail.com</p>
                                                </div>
                                                <div class="time_ago">
                                                    <span class="time">3hrs</span>
                                                    <span class="notif">5</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="info">
                                                    <img src="assets/images/thumb_5.png" alt="">
                                                    <h4>Jhon Doe</h4>
                                                    <p>abcdxyz@gmail.com</p>
                                                </div>
                                                <div class="time_ago">
                                                    <span class="time">3hrs</span>
                                                    <span class="notif">7</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="info">
                                                    <img src="assets/images/thumb_6.png" alt="">
                                                    <h4>Jhon Doe</h4>
                                                    <p>abcdxyz@gmail.com</p>
                                                </div>
                                                <div class="time_ago">
                                                    <span class="time">3hrs</span>
                                                    <span class="notif">2</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="info">
                                                    <img src="assets/images/thumb_7.png" alt="">
                                                    <h4>Jhon Doe</h4>
                                                    <p>abcdxyz@gmail.com</p>
                                                </div>
                                                <div class="time_ago">
                                                    <span class="time">3hrs</span>
                                                    <span class="notif">5</span>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:;">
                                                <div class="info">
                                                    <img src="assets/images/thumb_8.png" alt="">
                                                    <h4>Jhon Doe</h4>
                                                    <p>abcdxyz@gmail.com</p>
                                                </div>
                                                <div class="time_ago">
                                                    <span class="time">3hrs</span>
                                                    <span class="notif">3</span>
                                                </div>
                                            </a>
                                        </li>
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
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
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
                                                Lorem Ipsum is simply dummy text of the printing and typesetting industry.
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
                                                <textarea class="form-control"  name="typing" id="typing" placeholder="Type a message" required></textarea>
                                            </div>
                                            <div class="btn_type">
                                                <div class="upload">
                                                    <input type="file" class="file_upload" name="file_upload">
                                                    <button class="btn_upload" type="button">
                                                        <img src="assets/images/btn_upload.png" alt="">
                                                    </button>
                                                </div>
                                                <div class="btn_form">
                                                    <input type="submit" name="submit" class="btn_send" value="Send">
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
@endsection
