<?php

namespace App\Http\Controllers;
use App\Block;
use App\AttendanceSheet;
use Auth;
use App\blockStudents;
use Carbon\Carbon;

use Illuminate\Http\Request;

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
        $fromDate = Carbon::parse(Carbon::now()->toFormattedDateString())->startOfDay();
        $toDate = Carbon::parse(Carbon::now()->toFormattedDateString())->endOfDay();

        $user = auth()->user();
        $blocks = $user->blocks;

        $user = Auth::user();
        $UserAttendance = AttendanceSheet::where('user_id', '=', $user->id)
        ->whereBetween('created_at', [$fromDate, $toDate])
        ->get();
        return view('home',compact('blocks', 'user', 'UserAttendance'));
    }
}
