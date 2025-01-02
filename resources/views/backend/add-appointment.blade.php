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
                <div class="add_member bg_shade">
                    <div class="top_add">
                        <a href="javascript:;" class="btn_back">
                            <img src="{{asset('dashboard_assets/images/icon_left.png')}}" alt="">
                        </a>
                        <div class="ext">
                            <h2 class="sec_head ft_oswlad">Schedule New Appointment</h2>
                            <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium</p>
                        </div>
                        <a href="javascript:;" class="btn_custom">Schedule Now</a>
                    </div>
                    <div class="add_form">
                        <form action="" class="form" autocomplete="off">
                            <div class="row">
                                <div class="col-12">
                                    <div class="field drop_down">
                                        <label for="department">Select Department</label>
                                        <select class="form-control" name="department" id="department">
                                            <option value="" disabled selected>Select Department</option>
                                            <option value="Health Department">Health Department</option>
                                            <option value="Fire Department">Fire Department</option>
                                            <option value="Business Department">Business Department</option>
                                            <option value="Lorem Department">Lorem Department</option>
                                            <option value="Ipsum Department">Ipsum Department</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-5">
                                    <div class="field drop_down">
                                        <label for="member_list">Select Member</label>
                                        <select class="form-control" name="member_list" id="member_list">
                                            <option value="" disabled selected>Select</option>
                                            <option value="">Member 1</option>
                                            <option value="">Member 2</option>
                                            <option value="">Member 3</option>
                                            <option value="">Member 4</option>
                                            <option value="">Member 5</option>
                                        </select>
                                    </div>
                                    <div class="field">
                                        <label for="time_from">Select a time</label>
                                        <input type="text" class="form-control" id="time_from" name="time_from" placeholder="From">
                                        <input type="hidden" class="form-control" id="date_appoint" name="date_appoint" placeholder="From">
                                    </div>
                                    <div class="field">
                                        <label for="time_to">Select a time</label>
                                        <input type="text" class="form-control" id="time_to" name="time_to" placeholder="To">
                                    </div>
                                    <div class="field drop_down">
                                        <label for="duration">Select Member</label>
                                        <select class="form-control" name="duration" id="duration">
                                            <option value="" disabled selected>Select</option>
                                            <option value="">15 m</option>
                                            <option value="">30 m</option>
                                            <option value="">1 h</option>
                                            <option value="">1.5 h</option>
                                            <option value="">2 h</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-7">
                                    <div class="calander" id="calander_area">
                                        <div class="cd_nav">
                                            <h3 class="d-flex">
                                                <div class="txt">
                                                    <span id="month"> </span><span>&nbsp;</span><span id="year"> </span>
                                                </div>
                                                <div class="btns">
                                                    <a id="left" href="javascript:;"><i class="fa fa-chevron-left"> </i></a>
                                                    <a id="right" href="javascript:;"><i class="fa fa-chevron-right"> </i></a>
                                                </div>
                                            </h3>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">

                                                <div class="table_list">
                                                    <ul></ul>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</div>
<script type="text/javascript">

    $(document).ready(function() {
        var currentDate = new Date();
        function generateCalendar(d) {
            function monthDays(month, year) {
                var result = [];
                var days = new Date(year, month, 0).getDate();
                for (var i = 1; i <= days; i++) {
                    result.push(i);
                }
                return result;
            }
            Date.prototype.monthDays = function() {
                var d = new Date(this.getFullYear(), this.getMonth() + 1, 0);
                return d.getDate();
            };
            var details = {
                // totalDays: monthDays(d.getMonth(), d.getFullYear()),
                totalDays: d.monthDays(),
                weekDays: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
                months: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            };
            var start = new Date(d.getFullYear(), d.getMonth()).getDay();
            var cal = [];
            var day = 1;


            for (var i = 0; i <= 6; i++) {
                cal.push(['<li>']);
                for (var j = 0; j < 7; j++) {
                    if (i === 0) {
                        cal[i].push('<div class="top_col">' + details.weekDays[j] + '</div>');
                    } else if (day > details.totalDays) {
                        cal[i].push('<div class="box_div empty_col">&nbsp;</div>');
                    } else {
                        if (i === 1 && j < start) {
                            cal[i].push('<div class="box_div empty_col">&nbsp;</div>');
                        } else {
                            cal[i].push('<div class="box_div day">' + day++ + '</div>');
                        }
                    }
                }
                cal[i].push('</li>');
            }

            cal = cal.reduce(function(a, b) {
                return a.concat(b);
            }, []).join('');
            // $('.calander table').append(cal);

            $('.calander .table_list ul').append(cal);

            $('#month').text(details.months[d.getMonth()]);
            $('#year').text(d.getFullYear());

            $('.box_div').mouseover(function() {
                $(this).addClass('hover');
            }).mouseout(function() {
                $(this).removeClass('hover');
            });

        }
        $('#left').click(function() {
            $('.calander .table_list ul').text('');
            if (currentDate.getMonth() === 0) {
                currentDate = new Date(currentDate.getFullYear() - 1, 11);
                generateCalendar(currentDate);
            } else {
                currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() - 1)
                generateCalendar(currentDate);
            }
        });
        $('#right').click(function() {
            $('.calander .table_list ul').html('<li></li>');
            if (currentDate.getMonth() === 11) {
                currentDate = new Date(currentDate.getFullYear() + 1, 0);
                generateCalendar(currentDate);
            } else {
                currentDate = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1)
                generateCalendar(currentDate);
            }
        });
        generateCalendar(currentDate);
    });

    $(document).ready(function() {
        $('.table_list .box_div:not(.empty_col)').on('click',function() {
            let value = $(this).text();
            let month = $('.cd_nav h3 .txt #month').text();
            let year = $('.cd_nav h3 .txt #year').text();
            // alert(value);
            $('#date_appoint').attr('value','');
            $(this).parents('ul').find('.box_div.active').removeClass('active');
            $(this).addClass('active');
            let date_appoint = value + '-' + month + '-' + year;
            $('#date_appoint').attr('value',date_appoint);
        })

        $('#right').click(function() {
            $('#date_appoint').attr('value','');
            $('.table_list').find('.box_div.active').removeClass('active');
        });

        $('#left').click(function() {
            $('#date_appoint').attr('value','');
        });

    })

</script>
@endsection
