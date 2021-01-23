<?php

namespace App\Http\Controllers;

use App\Kade;
use App\Planning;
use App\TijdTabel;
use App\User;
use Carbon\Carbon;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use function Sodium\add;

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
        $kades = Kade::get();
        $result = compact('kades');

        Json::dump($result);
        return view('home', $result);
    }

    public function kade(){
        $kades = Kade::orderBy('kadeNaam')->get();



        return $kades;


    }
    public function getinfo(Request $request){
        $id = $request->request->get('id');

        $planningen = Planning::orderBy('startTijd')
            ->Join('tijd_tabels', 'plannings.tijdTabelID', '=', 'tijd_tabels.id')
            ->Join('gebruikers', 'plannings.gebruikerID', '=', 'gebruikers.id')
            ->Join('bedrijfs', 'gebruikers.bedrijfs_id', '=', 'bedrijfs.id')
            ->Join('nummerplaats', 'bedrijfs.id', '=', 'nummerplaats.bedrijfID')
            ->Join('kades', 'plannings.kadeID', '=', 'kades.id')
            ->get();


        foreach($planningen as $planning){
            if($planning->id == $id){
                return $planning;
            }
        }


        /*

        */



        return $planningen;


    }

    public function planningChauffeur(Request $request){
        $user = Auth::user();
        //huidig uur
        $dt = date('Y-m-d H:i',time());
        //24 uur na huidig uur
        $dt2= date('Y-m-d H:i',time()+86400);
        $planningen = Planning::orderBy('startTijd')
            ->Join('tijd_tabels', 'plannings.tijdTabelID', '=', 'tijd_tabels.id')
            ->Join('gebruikers', 'plannings.gebruikerID', '=', 'gebruikers.id')
            ->Join('bedrijfs', 'gebruikers.bedrijfs_id', '=', 'bedrijfs.id')
            ->Join('nummerplaats', 'bedrijfs.id', '=', 'nummerplaats.bedrijfID')
            ->Join('kades', 'plannings.kadeID', '=', 'kades.id')
            ->where('startTijd','<',$dt2)
            ->where('startTijd','>',$dt)
            ->where('gebruikerID',$user->id)
            ->get();



        foreach($planningen as $planning){
            if($planning->gebruikerID == $user->id){
                return $planning;
            }
        }

        return $planningen;

    }
    public function getPlanninglogistiek(Request $request){
        $id = $request->request->get('id');
        //huidig uur
        $dt = date('Y-m-d H:i',time()-7200);
        //24 uur na huidig uur
        $dt2= date('Y-m-d H:i',time()+7200);
        $planningen = Planning::orderBy('startTijd')
            ->Join('tijd_tabels', 'plannings.tijdTabelID', '=', 'tijd_tabels.id')
            ->Join('gebruikers', 'plannings.gebruikerID', '=', 'gebruikers.id')
            ->Join('bedrijfs', 'gebruikers.bedrijfs_id', '=', 'bedrijfs.id')
            ->Join('nummerplaats', 'bedrijfs.id', '=', 'nummerplaats.bedrijfID')
            ->Join('kades', 'plannings.kadeID', '=', 'kades.id')
            ->where('startTijd','<',$dt2)
            ->where('startTijd','>',$dt)
            ->where('isAanwezig', '=',1)
            ->where('isAfgewerkt', '=', 0)
            ->where('kadeID', 'like', $id)
            ->get();



        foreach($planningen as $planning){
            if($planning->isBezig == 1){
                return $planning;
            }

        }
        foreach($planningen as $planning){
            return $planning;


        }
        $kade = Kade::orderBy('kadeNaam')->find($id);
        return $kade;

    }


    public function dagplanning(Request $request){
        //12 uur voor huidig uur
        $dt = date('Y-m-d H:i',time()-43200);
        //12 uur na huidig uur
        $dt2= date('Y-m-d H:i',time()+43200);

        //geeft alle planningen terug die 12 uur voor het huidig uur zijn en 12 uur na het huidig uur zijn
        $planningen = Planning::orderBy('startTijd')
            ->Join('tijd_tabels', 'plannings.tijdTabelID', '=', 'tijd_tabels.id')
            ->Join('gebruikers', 'plannings.gebruikerID', '=', 'gebruikers.id')
            ->Join('bedrijfs', 'gebruikers.bedrijfs_id', '=', 'bedrijfs.id')
            ->Join('nummerplaats', 'bedrijfs.id', '=', 'nummerplaats.bedrijfID')
            ->Join('kades', 'plannings.kadeID', '=', 'kades.id')
            ->where('startTijd','<',$dt2)
            ->where('startTijd','>',$dt)
            ->get();

        $planningen[0]->dt2 =$dt2;



        return $planningen;
    }
}
