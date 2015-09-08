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
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Send message</div>

                    <form method="POST" id="send_form">

                        <div class="btn-group" role="group" aria-label="...">

                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <div id="choosen_user">User</div>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu">
                                    @foreach($users as $user)

                                        <li><a href="javascript:void(0)"
                                               onclick="set_user('{{ $user->id }}','{{ $user->name }}')">{{ $user->name }}</a>
                                        </li>

                                    @endforeach


                                </ul>
                            </div>
                        </div>

                        <input type="text" class="send_txt" name="message">
                        <input type="submit" class="send_bt" value="send">
                    </form>
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


        socket.on('message', function (js_data) {

            console.log("message --->" + js_data);
            $("#messages").append("<div class='message animation-slideUp'> <div><label class='sender_label'>New Message : <span class='sender_span'>" + js_data + "</span></label></div></div>");

        });


        var receiver_name = "";
        var receiver_id = "";

        //var host = "http://localhost:8000/";
        //var host = "http://192.168.0.105:8000/";


        $(document).ready(function () {



            //var url = window.location.href;
            var url = window.location.host ;
            console.log("current utl ---->"+url);
            // var host = "http://localhost:8000/";

            $('#send_form').on('submit', function (e) {
                console.log("form submitted with :reciever_name: " + receiver_name + " --->reciever_id -->" + receiver_id);

                e.preventDefault();

                var msg = $(this).find('input[name=message]').val();


                //get_logged_user(function (logged_user_id) {

                // console.log("inside  get logged_user function");
                socket.emit('message', msg, receiver_id);


                // });


                /*$.ajax({
                 type: "POST",
                 url: host + 'sendmessage',
                 data: {msg: msg, receiver_name: receiver_name, receiver_id: receiver_id},
                 headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 },
                 }).done(function (response) {

                 console.log(response.msg)


                 });*/

            });
        });

        function set_user(id, user_name) {


            $('#choosen_user').html(user_name);
            console.log("id ---> " + id);

            receiver_id = id;
            receiver_name = user_name;
        }
    </script>

@endsection


