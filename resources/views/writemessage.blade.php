@extends('app')

@section("css")

    <style>

        .send_bt, .send_txt {
            height: 51px;
            border: 2px groove rgba(123, 132, 123, 0.24)

        }

        .message {
            background-color: rgba(197, 186, 204, 0.62);
            border-radius: 20px;
            padding-top: 6px;
            padding-bottom: 6px;
            padding-left: 15px;
            color: #2D46D2;
            border-bottom: 2px solid #4EDA4E;
        }

        .message:hover {
            background-color: rgba(164, 204, 157, 0.62);
            cursor: hand;
        }

        .message:active {
            background-color: rgb(115, 129, 163);
        }

        .sender_label {
            color: green;
            font-family: Consolas;
            font-size: medium;
        }

        .sender_span {
            color: black;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: small;
        }

    </style>

@endsection

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-4 user_list_chat">


                <ul>
                    @foreach($users as $user)

                        <li class="user_chat animation-slideExpandUp" id='{{ $user->id }}'><a href="javascript:void(0)"
                                                                                              onclick="set_user('{{ $user->id }}','{{ $user->name }}','{{ $user->avatar }}')"><img
                                        title="{{ $user->name  }}"
                                        src="{{ $user->avatar }}" class="user_avatar"></a>
                        </li>

                    @endforeach


                </ul>

            </div>


            <div class="col-md-6 col-md-offset-1">

                <div class="chat_panel ">


                    <div class="msg_bar">


                        <div id="msgs_area" class="msgs_area">

                            <div id="msgs">


                            </div>


                        </div>


                        <div>

                            <div class="is_typing" style="margin-left: -251px;"></div>
                            <input onkeypress="is_typing()" type="text" id=msg_txt" class="msg_txt"
                                   placeholder="Enter your message"/>

                            <button onclick="send_message()" class="send_btn">Send</button>
                        </div>


                    </div>


                </div>


            </div>
        </div>
    </div>
    </div>




@endsection


@section("js")




    <script language="javascript">


        var receiver_name = "";
        var receiver_id = "";
        var receiver_avatar = "";
        var is_typing_flag = false;

        $('.msg_txt').val("");
        socket.on('message', function (js_data) {

            $('#msgs').append('<div class="sender_msg animation-stretchRight"><img class="sender_path" ' +
                    'src=' + receiver_avatar + '>&nbsp;&nbsp;&nbsp;' + js_data + '</div>');


        });


        socket.on('is_typing', function (js_data) {
            $('.is_typing').html(js_data + ' is typing');

            console.log(js_data + ' is typing');
            if (!is_typing_flag) {

                $('.is_typing').animate({'opacity': 1}, 500);
                is_typing_flag = true;

                setTimeout(function () {
                    is_typing_flag = false;
                    $('.is_typing').animate({
                        'opacity': 0
                    }, 500);
                }, 1000);


            }


        });


        function send_message() {


            var msg = $('.msg_txt').val();
            $('#msgs').append('<div class="current_user_msg animation-stretchLeft">' + msg + '</div>');
            socket.emit('message', msg, receiver_id);
            $('.msg_txt').val("");


        }


        function is_typing() {

            socket.emit('is_typing', logged_user.user_name, receiver_id);


        }


        function set_user(id, user_name, user_avatar) {


            $('.user_chat').removeClass("active_user");
            $('#' + id).addClass("active_user");
            $('#choosen_user').html(user_name);
            console.log("id ---> " + id);
            console.log("name ---> " + user_name);
            console.log("avatar --->" + user_avatar);
            receiver_id = id;
            receiver_avatar = user_avatar;

        }

    </script>

@endsection


