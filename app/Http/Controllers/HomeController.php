<?php namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\Response;

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
        $this->middleware('auth');
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

}
