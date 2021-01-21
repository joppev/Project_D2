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
        $kades = Planning::orderBy('startTijd')
            ->LeftJoin('tijd_tabels', 'plannings.tijdTabelID', '=', 'tijd_tabels.id')
            ->LeftJoin('gebruikers', 'plannings.gebruikerID', '=', 'gebruikers.id')
            ->LeftJoin('bedrijfs', 'gebruikers.bedrijfs_id', '=', 'bedrijfs.id')
            ->LeftJoin('nummerplaats', 'bedrijfs.id', '=', 'nummerplaats.bedrijfID')
            ->LeftJoin('kades', 'plannings.kadeID', '=', 'kades.id')
            ->get();


        return $kades;
    }
}
