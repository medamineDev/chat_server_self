@extends('app')

@section("meta")
    <meta name="logged_user" content="{{ $user }}"/>
@endsection

@section("style")
    <style>
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
    {{--<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
    <script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script src="https://cdn.socket.io/socket.io-1.3.4.js"></script>--}}


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
        //var socket = io.connect('http://localhost:8890');
        var socket = io.connect('http://192.168.0.105:8890');
        socket.on('message', function (js_data) {
            console.log("message --->" + js_data);

            $("#messages").append("<div class='message animation-slideUp'> <div><label class='sender_label'>New Message : <span class='sender_span'>" + js_data + "</span></label></div></div>");

            //console.log("current user --->"+current_user);
            //console.log("message sent to user --->"+data.to);


            //$("#messages").append("<div class='message animation-slideUp'> <div><label class='sender_label'>" + data.from + ": <span class='sender_span'>" + data.msg + "</span></label></div></div>");

            /*  if (current_user == data.to) {



             $("#messages").append("<div class='message animation-slideUp'> <div><label class='sender_label'>" + data.from + ": <span class='sender_span'>" + data.msg + "</span></label></div></div>");
             }*/

        });

    </script>


@endsection