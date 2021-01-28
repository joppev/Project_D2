<?php

namespace App\Http\Controllers;

use App\Kade;
use App\Nummerplaat;
use App\Planning;
use App\User;
use Carbon\Carbon;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
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

    public function getnummerplaten(Request $request){
        $id = $request->request->get('id');
        $nummerplaten = Nummerplaat::orderBy('id')
            ->where('bedrijfID','=',$id)
        ->get();

        return $nummerplaten;

    }
    public function kade(Request $request){
        $text =  '%'.$request->request->get('text').'%';

    $kades = Kade::orderBy('kadeNaam')
        ->where(function ($query) use ($text) {
            $query->where('kadenaam', 'like', $text)
                ->orwhere('status', 'like', $text);
        })
        ->get();






        return $kades;


    }
    public function getinfo(Request $request){
        $id = $request->request->get('id');

        $planningen = Planning::orderBy('id')
            ->Join('users', 'plannings.gebruikerID', '=', 'users.id')
            ->Join('bedrijfs', 'users.bedrijfsID', '=', 'bedrijfs.id')

            ->Join('kades', 'plannings.kadeID', '=', 'kades.id')
            ->select('plannings.*','kades.status as status','kades.kadenaam as kadenaam','bedrijfs.bedrijfsnaam as bedrijfsnaam', 'users.voornaam as voornaam', 'users.naam as naam','bedrijfs.id as bedrijfsID')
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
        $planningen = Planning::orderBy('id')
            ->Join('users', 'plannings.gebruikerID', '=', 'users.id')
            ->Join('bedrijfs', 'users.bedrijfsID', '=', 'bedrijfs.id')

            ->Join('kades', 'plannings.kadeID', '=', 'kades.id')
            ->select('plannings.*','kades.status as status','kades.kadenaam as kadenaam','bedrijfs.bedrijfsnaam as bedrijfsnaam', 'users.voornaam as voornaam', 'users.naam as naam','bedrijfs.id as bedrijfsID', 'kades.gemeente as gemeente','kades.adres as adres','kades.land as land')
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
    public function begin(Request $request){
        $id = $request->request->get('id');

        $idkade = $request->request->get('idKade');

        //huidig uur
        $dt = date('Y-m-d H:i',time()-7200);
        //24 uur na huidig uur
        $dt2= date('Y-m-d H:i',time()+7200);
        $planning = Planning::orderBy('id')
            ->Join('users', 'plannings.gebruikerID', '=', 'users.id')
            ->Join('bedrijfs', 'users.bedrijfsID', '=', 'bedrijfs.id')

            ->Join('kades', 'plannings.kadeID', '=', 'kades.id')
            ->select('plannings.*','kades.status as status','kades.kadenaam as kadenaam','bedrijfs.bedrijfsnaam as bedrijfsnaam', 'users.voornaam as voornaam', 'users.naam as naam','bedrijfs.id as bedrijfsID')
            ->where('startTijd','<',$dt2)
            ->where('startTijd','>',$dt)
            ->where('isAanwezig', '=',1)
            ->where('isAfgewerkt', '=', 0)
            ->where('kadeID', 'like',$idkade)
            ->where('plannings.id','like',$id)

            ->first();

        $kade = Kade::findOrFail($idkade);
        $kade->status = 'Niet-vrij';
        $kade->save();

        if ($planning != null){
            $planningBegin = Planning::findOrFail($id);
            $planningBegin->isBezig = 1  ;
            $planningBegin->isAfgewerkt = 0 ;


            //$planningBegin->update();
            $planningBegin->save();


            return response()->json([
                'type' => 'success',
                'text' => "Begonnen aan proces bedrijf: <b>$planning->bedrijfsnaam</b> aan kade <b>$planning->kadenaam</b>"
            ]);
        }else{

            return response()->json([
                'type' => 'error',
                'text' => "geen planning gevonden die aan deze kadeid <b>$idkade</b> en id <b>$id</b> heeft"
            ]);

        }


    }
    public function afgewerkt(Request $request){
        $id = $request->request->get('id');
        $idkade = $request->request->get('idKade');

        //huidig uur
        $dt = date('Y-m-d H:i',time()-7200);
        //24 uur na huidig uur
        $dt2= date('Y-m-d H:i',time()+7200);
        $planning = Planning::orderBy('id')
            ->Join('users', 'plannings.gebruikerID', '=', 'users.id')
            ->Join('bedrijfs', 'users.bedrijfsID', '=', 'bedrijfs.id')

            ->Join('kades', 'plannings.kadeID', '=', 'kades.id')
            ->select('plannings.*','kades.status as status','kades.kadenaam as kadenaam','bedrijfs.bedrijfsnaam as bedrijfsnaam', 'users.voornaam as voornaam', 'users.naam as naam','bedrijfs.id as bedrijfsID')
            ->where('startTijd','<',$dt2)
            ->where('startTijd','>',$dt)
            ->where('isAanwezig', '=',1)
            ->where('isBezig', '=', 1)
            ->where('isAfgewerkt', '=', 0)
            ->where('kadeID', 'like',$idkade)
            ->where('plannings.id','like',$id)

            ->first();


        $kade = Kade::findOrFail($idkade);
        $kade->status = 'Vrij';
        $kade->save();

        if ($planning != null){
            $planningBegin = Planning::findOrFail($id);
            $planningBegin->isBezig = 0  ;
            $planningBegin->isAfgewerkt = 1 ;


            //$planningBegin->update();
            $planningBegin->save();


            return response()->json([
                'type' => 'success',
                'text' => "Proces bedrijf: <b>$planning->bedrijfsnaam</b> aan kade <b>$planning->kadenaam</b> afgewerkt"
            ]);
        }else{

            return response()->json([
                'type' => 'error',
                'text' => "geen planning gevonden die aan deze kadeid <b>$idkade</b> en id <b>$id</b> heeft"
            ]);

        }


    }




    public function getPlanninglogistiek(Request $request){
        $id = $request->request->get('id');
        //huidig uur
        $dt = date('Y-m-d H:i',time()-7200);
        //24 uur na huidig uur
        $dt2= date('Y-m-d H:i',time()+7200);
        $planningen = Planning::orderBy('id')
            ->Join('users', 'plannings.gebruikerID', '=', 'users.id')
            ->Join('bedrijfs', 'users.bedrijfsID', '=', 'bedrijfs.id')

            ->Join('kades', 'plannings.kadeID', '=', 'kades.id')
            ->select('plannings.*','kades.status as status','kades.kadenaam as kadenaam','bedrijfs.bedrijfsnaam as bedrijfsnaam', 'users.voornaam as voornaam', 'users.naam as naam','bedrijfs.id as bedrijfsID')
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
        $text = '%' . $request->request->get('text') . '%';
        $text2 = $request->request->get('text');
        //12 uur voor huidig uur
        $dt = date('Y-m-d H:i',time()-43200);
        //12 uur na huidig uur
        $dt2= date('Y-m-d H:i',time()+43200);


    $planningen = Planning::orderBy('id')
        ->Join('users', 'plannings.gebruikerID', '=', 'users.id')
        ->Join('bedrijfs', 'users.bedrijfsID', '=', 'bedrijfs.id')
        ->Join('kades', 'plannings.kadeID', '=', 'kades.id')
        ->select('plannings.*','kades.status as status','kades.kadenaam as kadenaam','bedrijfs.bedrijfsnaam as bedrijfsnaam', 'users.voornaam as voornaam', 'users.naam as naam','bedrijfs.id as bedrijfsID')
->where('startTijd','<',$dt2)
        ->where('startTijd','>',$dt)
        ->where(function ($query) use ($text) {
            $query->where('volledigeNaam', 'like', $text)
                ->orwhere('kadenaam', 'like', $text)
                ->orwhere('bedrijfsnaam', 'like', $text)
                ->orwhere('proces', 'like', $text)

            ;

        })
        ->get();



        if(!$planningen->isEmpty()){


            $planningen[0]->dt2 =date('Y-m-d H:i',time());

        }





        return $planningen;
    }
}
