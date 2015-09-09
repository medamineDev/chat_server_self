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
                    {{--<div class="panel-heading">Send message</div>--}}

                    {{--<form method="POST" id="send_form" style="margin-left: -118px;">--}}




                    {{--<div class="btn-group" role="group" aria-label="...">--}}

                    {{--<div class="btn-group" role="group">--}}
                    {{--<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"--}}
                    {{--aria-haspopup="true" aria-expanded="false">--}}
                    {{--<div id="choosen_user">User</div>--}}
                    {{--<span class="caret"></span>--}}
                    {{--</button>--}}


                    {{--<!-- When this element is clicked, hide the tooltip -->--}}
                    {{--<div id="main">--}}

                    {{--<!-- This is the tooltip. It is shown only when the showtooltip variable is truthful -->--}}
                    {{--<div class="user_tooltip  animation-slideExpandUp">--}}


                    {{--<ul>--}}


                    {{--@foreach($users as $user)--}}

                    {{--<li><a href="javascript:void(0)"--}}
                    {{--onclick="set_user('{{ $user->id }}','{{ $user->name }}')"><img--}}
                    {{--src="{{ $user->avatar }}"></a>--}}
                    {{--</li>--}}

                    {{--@endforeach--}}


                    {{--</ul>--}}


                    {{--</div>--}}


                    {{--<img class="search_str_header">--}}

                    {{--</div>--}}


                    {{--<ul class="dropdown-menu" style="display: none">--}}
                    {{--@foreach($users as $user)--}}

                    {{--<li><a href="javascript:void(0)"--}}
                    {{--onclick="set_user('{{ $user->id }}','{{ $user->name }}')">{{ $user->name }}</a>--}}
                    {{--</li>--}}

                    {{--@endforeach--}}


                    {{--</ul>--}}
                    {{--</div>--}}
                    {{--</div>--}}

                    {{--  <input type="text" class="send_txt" name="message">
                      <input type="submit" class="send_bt" value="send">--}}
                    {{--</form>--}}
                    {{--<ul>--}}


                    <div class="msg_bar">


                        <div id="msgs_area" class="msgs_area">

                            <div id="msgs">
                                <div class="current_user_msg animation-stretchLeft">Me hello</div>
                                <div class="sender_msg animation-stretchRight"><img class="sender_path"
                                                                                    src="{{ asset('/imgs/avatar.png') }}"/>&nbsp;&nbsp;&nbsp;
                                    sender hiii
                                </div>

                            </div>

                        </div>


                        <div>
                            <input type="text" id=msg_txt" class="msg_txt" placeholder="Enter your message"/>

                            <button onclick="send_message()" class="send_btn">Send</button>
                        </div>


                    </div>


                </div>


            </div>
        </div>
    </div>
    </div>












    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">

                <div id="messages"></div>
            </div>
        </div>
    </div>





@endsection


@section("js")




    <script language="javascript">


        var receiver_name = "";
        var receiver_id = "";
        var receiver_avatar = "";

        socket.on('message', function (js_data) {

            console.log("message --->" + js_data);
            // $("#messages").append("<div class='message animation-slideUp'> <div><label class='sender_label'>New Message : <span class='sender_span'>" + js_data + "</span></label></div></div>");


            $('#msgs').append('<div class="sender_msg animation-stretchRight"><img class="sender_path" ' +
                    'src=' + receiver_avatar + '/>&nbsp;&nbsp;&nbsp;' + js_data + '</div>');


        });





        function send_message() {


            var msg = $('.msg_txt').val();
            console.log("message -------->"+msg);
            $('#msgs').append('<div class="current_user_msg animation-stretchLeft">' + msg + '</div>');

            socket.emit('message', msg, receiver_id);


        }


        function set_user(id, user_name, user_avatar) {


            $('.user_chat').removeClass("active_user");
            $('#' + id).addClass("active_user");
            $('#choosen_user').html(user_name);
            console.log("id ---> " + id);
            console.log("avatar --->" + user_avatar);

            receiver_id = id;
            receiver_name = user_name;
            receiver_avatar = user_avatar;
        }
    </script>

@endsection


