<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Response;
use  Illuminate\Support\Facades\Paginator;
use App\User;
use App\Message;

use Illuminate\Http\RedirectResponse;
use DB;

use Input;

class HomeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //  $this->middleware('auth');
        $this->middleware('guest');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function index()
    {
        return view('home');
    }


    /**
     * @return json
     *
     *
     */

    public function get_logged_user()
    {

        $id = Auth::id();
        $name = Auth::user()->name;
        $email = Auth::user()->email;


        $response = Array(

            'user_id' => $id,
            'user_name' => $name,
            'user_email' => $email

        );

        return Response::json($response);


    }







    public function registered_phones_api()
    {

        $var = $input = Input::all();
        $var = $input['contacts'];
        $arr = explode(",", $var);
        $existing_contacts = [];
        $i = 0;
        $lenght = count($arr) - 1;


        while ($i <= $lenght) {
            if ($i == 0) {

                $tarr = trim($arr[$i], '[');

                $user_phone = $tarr;


            } elseif ($i == $lenght) {


                $tarr = trim($arr[$i], ']');
                $user_phone = $tarr;


            } else {

                $user_phone = $arr[$i];
            }


            $user = User::where('user_phone', $user_phone)->get();

            if (!$user->isEmpty()) {

                $user_id = $user[0]->user_id;
                $existing_contacts[] = array('id' => $user_id, 'number' => $user_phone);

            }


            $i++;


        }

        return Response::json($existing_contacts);


    }


    function login_api()
    {


        $user_phone = Input::get('user_phone');

        $user = User::where('user_phone', $user_phone)->get();

        if (!$user->isEmpty()) {
            return Response::json([
                'status' => "user exist",
                'user_found' => $user
            ]);

        } else {


            $code_header = '400';
            $header = "login_api_header";
            return response($header)
                ->header('status', $code_header)
                ->header('Content-Type', 'user Not exist');
        }

    }


    public function register_api()
    {


        $user_phone = Input::get('user_phone');


        $user_list = User::where('user_phone', $user_phone)->get();

        if ($user_list->isEmpty()) {

            $user = new User();
            $user->user_phone = $user_phone;
            $saved = $user->save();

            if ($saved) {

                return Response::json([
                    'status' => 201,
                    'user_id' => $user->id
                ]);

            } else {

                $code_header = '400';
                $header = "register_api_header";
                return response($header)
                    ->header('status', $code_header)
                    ->header('Content-Type', 'user could not be saved');

            }
        } else {


            $user_id = $user_list[0]->user_id;

            return Response::json([
                'status' => 200,
                'user_id' => $user_id,
                'msg' => "user mail exists !"
            ]);


        }


    }


    public function send_msg_api()
    {


        $id_sender = Input::get('id_sender');
        $id_receiver = Input::get('id_receiver');
        $message_body = Input::get('message_body');


        $message = new Message();
        $message->id_sender = $id_sender;
        $message->id_receiver = $id_receiver;
        $message->message_body = $message_body;

        $saved = $message->save();

        if ($saved) {
            return Response::json([
                'status' => 200,
                'msg' => 'message was saved'
            ]);

        } else {


            $code_header = '400';
            $header = "send_msg_api_header";
            return response($header)
                ->header('status', $code_header)
                ->header('Content-Type', 'message was not saved');


        }


    }


    public function get_msgs_api()
    {


        $id_sender = Input::get('my_id');
        $id_receiver = Input::get('id_user_chat');

        $response = Message::where('id_sender', $id_sender)->where('id_receiver', $id_receiver)->orWhere('id_sender', $id_receiver)->Where('id_receiver', $id_sender)->Paginate(2);


        return $response;


    }


}
