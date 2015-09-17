@extends('app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Home</div>

                    <div class="panel-body">
                        You are logged in!
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




@section('js')


    <script language="javascript">

        function get_registred_phones() {

            console.log("inside  get_registred_phones  ---> host --->" + host);

            /*var contacts = [
             '52.635.904',
             '22.506.791',
             '22.506.792',
             '22.568.793',
             '22.567.794',
             '22.563.795',
             '22.561.796',
             '22.569.797',
             '22.506.794'
             ];*/

            var contacts = "22.506.794,52635904,52.635.901";

            //var jsonString = JSON.stringify(contacts);

            $.ajax({
                type: "POST",
                url: host + '/registred_phones_api',
                data: {contacts: contacts}
            }).done(function (response) {

                console.log(response.contacts);


            });

        }


        get_registred_phones();
    </script>

@endsection