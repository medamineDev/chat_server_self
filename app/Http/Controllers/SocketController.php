<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Controller;
use Request;
use LRedis;

use App\User;
use Auth;
use Illuminate\Support\Facades\Input;


class SocketController extends Controller
{


    public function __construct()
    {
        //$this->middleware('guest');
        $this->middleware('auth');
    }

    public function index()
    {

        // $users = User::all();

        // $users = array("from" => "amine", "to" => "salem", "msg" => "hello Salem");


        //return view('socket', ['$users' => $users]);
        //return View::make('socket', ['$users' => $users]);

        /*
                $users = User::all();

                $one_user = user::find(2);

                // return view("articles", compact("articles"));*/

        $userId = Auth::id();
        $useremail = Auth::user()->email;
        $userName = Auth::user()->name;

        $user = array("user_id" => $userId, "user_name" => $userName, "user_email" => $useremail);
        return view("socket")->with([
            "user" => $userId
        ]);


        //return view('socket');

    }

    public function writemessage()
    {

        $users = User::all();
        return view("writemessage")->with([
            "users" => $users
        ]);

        // return view('writemessage');

    }

    public function sendMessage()
    {

        $redis = LRedis::connection();;


        $userId = Auth::id();
        $useremail = Auth::user()->email;
        $userName = Auth::user()->name;

        if (Request::ajax()) {
            $msg = Input::get('msg', 'the msg is empty');
            $to = Input::get('receiver_id', 'the receiver Id is empty');


            $msg_arr = array("from" => $userName, "to" => $to, "msg" => $msg);

            $redis->publish('message', json_encode($msg_arr));


            $response = array(
                'status' => 'success',
                'msg' => 'the message was sent with success',
                'from' => $userName,
                'to' => $to
            );

            return Response::json($response);
        } else {
            $response = array(
                'status' => 'error',
                'msg' => "the message wasn't sent ",

            );

            return Response::json($response);
        }

        return redirect('writemessage');

        /*


                $msg_arr = array("from" => $userName, "to" => "salem", "msg" => "hello Salem");


                //$redis->publish('message', Request::input('message'));
                $redis->publish('message', json_encode($msg_arr));

                return redirect('writemessage');*/

    }


}
