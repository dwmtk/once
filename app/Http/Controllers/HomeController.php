<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Attend;
use App\Event;
use Illuminate\Support\Facades\Auth;
use App\Mail\SendRegisterMail;

class HomeController extends Controller
{
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // ユーザが参加済みの一覧を取得　※欠席も含む
        $my_events = Attend::getAttendEventsAll(Auth::id());
        return view('home')->with(['my_events' => $my_events]);
    }
}
