<?php

namespace App\Http\Controllers;

use App\Kade;
use App\Planning;
use App\TijdTabel;
use App\User;
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


        return view('home');
    }
    public function kade(){
        $kades = Kade::orderBy('naam')->get();



        return $kades;


    }
    public function dagplanning(){
        $kades = Planning::orderBy('naam')
            ->LeftJoin('tijd_tabels', 'kade.startTijd', '=', 'tijd_tabels.startTijd')
            ->LestJoin('tijd_tabels', 'kade.stopTijd', '=', 'tijd_tabels.stopTijd')
            ->get();


        return $kades;
    }
}
