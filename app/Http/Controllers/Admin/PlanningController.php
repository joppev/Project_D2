<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Planning;
use Carbon\Carbon;
use DateTime;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PlanningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.planning.planning');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'startdate' => 'required|before_or_equal:stopdate',
            'starttime' => 'required',
            'stopdate' => 'required',
            'stoptime' => 'required',
            'user_id' => 'digits:1',
            'kade_id' => 'digits:1',
            'proces' => 'required|min:3|max:255',
            'aantal' => 'required|numeric',
            'lading' => 'required|min:3|max:255',
            'status' => 'digits:1',
        ]);
        $planning = new Planning();
        $planning->gebruikerID = (int)$request->user_id;
        $planning->kadeID = (int)$request->kade_id;

        /*$planning->startTijd = Carbon::createFromTimeString($request->starttijd)->format('d-m-Y');
        $planning->stopTijd = Carbon::createFromTimeString($request->stoptijd)->format('d-m-Y');*/
        /*$starttime = DateTime::createFromFormat('H:i',$request->starttime);

        $startdate = DateTime::createFromFormat('Y-m-d',$request->startdate);

        $stoptime = DateTime::createFromFormat('H:i',$request->stoptime);*/

        $planning->proces = $request->proces;
        $planning->ladingDetails = $request->lading;
        $planning->aantal = $request->aantal;


        $time = date('H:i:s', strtotime($request->starttime));
        $begin = $request->startdate." ".$time;

        $time2 = date('H:i:s', strtotime($request->stoptime));
        $stop = $request->stopdate." ".$time2;

        $planning->startTijd = $begin;
        $planning->stopTijd = $stop;



        if($request->stopdate = $request->startdate){
            $this->validate($request,[
                'startdate' => 'required|before_or_equal:stopdate',
                'starttime' => 'required|before:stoptime',
                'stopdate' => 'required',
                'stoptime' => 'required',
                'user_id' => 'digits:1',
                'kade_id' => 'digits:1',
                'proces' => 'required|min:3|max:255',
                'aantal' => 'required|numeric',
                'lading' => 'required|min:3|max:255',
                'status' => 'digits:1',
            ]);
        }
        $planningen  = DB::table('plannings')
                        ->get();
        $fout = false;
        foreach($planningen as $p){
            if($p->kadeID == $planning->kadeID){
                Json::dump($planning->kadeID);
                if($p->startTijd > $planning->startTijd && $p->startTijd < $planning->stopTijd){
                    $fout = true;

                }else if($planning->startTijd < $p->stopTijd && $planning->stopTijd > $p->stopTijd){
                    $fout = true;
                } else if ($planning->startTijd > $p->startTijd && $planning->stopTijd < $p->stopTijd){
                    $fout = true;
                }  else if ($planning->startTijd < $p->startTijd && $planning->stopTijd > $p->stopTijd){
                    $fout = true;
                } else {
                    $fout = false;
                }
            }
        }

        if ($fout){
            $this->validate($request,[
                'startdate' => 'required',
                'starttime' => 'required',
                'stopdate' => 'required',
                'stoptime' => 'required',
                'user_id' => 'digits:1',
                'kade_id' => 'digits:1|ip',
                'proces' => 'required|min:3|max:255',
                'aantal' => 'required|numeric',
                'lading' => 'required|min:3|max:255',
                'status' => 'digits:1',
            ]);
        }



        $status = $request->status;

        if($status === "1"){
            $planning->isAanwezig = false;
            $planning->isBezig = false;
            $planning->isAfgewerkt = true;
        } elseif($status === "2"){
            $planning->isAanwezig = false;
            $planning->isBezig = true;
            $planning->isAfgewerkt = false;
        }
        elseif($status === "3"){
            $planning->isAanwezig = false;
            $planning->isBezig = false;
            $planning->isAfgewerkt = true;
        } else{
            $planning->isAanwezig = false;
            $planning->isBezig = false;
            $planning->isAfgewerkt = false;
        }

        $planning->save();
        return response()->json([
            'type' => 'success',
            'text' => "Planning is toegevoegd. "
        ]);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function show(Planning $planning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function edit(Planning $planning)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Planning $planning)
    {

        $this->validate($request,[
            'startdate' => 'required',
            'starttime' => 'required',
            'stopdate' => 'required',
            'stoptime' => 'required',
            'user_id' => 'digits:1',
            'kade_id' => 'digits:1',
            'proces' => 'required|min:3|max:255',
            'aantal' => 'required|numeric',
            'lading' => 'required|min:3|max:255',
            'status' => 'digits:1',
        ]);

        $planning->gebruikerID = (int)$request->user_id;
        $planning->kadeID = (int)$request->kade_id;


        $time = date('H:i:s', strtotime($request->starttime));
        $begin = $request->startdate." ".$time;

        $time2 = date('H:i:s', strtotime($request->stoptime));
        $stop = $request->stopdate." ".$time2;

        $planning->startTijd = $begin;
        $planning->stopTijd = $stop;


//        $planning->stopTijd =\Carbon\Carbon::parse($request->stoptijd)->format('Y-m-d H:i');
        $planning->proces = $request->proces;
        $planning->ladingDetails = $request->lading;
        $planning->aantal = $request->aantal;

        $status = $request->status;

        if($status === "1"){
            $planning->isAanwezig = false;
            $planning->isBezig = false;
            $planning->isAfgewerkt = true;
        } elseif($status === "2"){
            $planning->isAanwezig = false;
            $planning->isBezig = true;
            $planning->isAfgewerkt = false;
        }
        elseif($status === "3"){
            $planning->isAanwezig = false;
            $planning->isBezig = false;
            $planning->isAfgewerkt = true;
        } else{
            $planning->isAanwezig = false;
            $planning->isBezig = false;
            $planning->isAfgewerkt = false;
        }

        $planning->save();
        return response()->json([
            'type' => 'success',
            'text' => "Planning is aangepast. "
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function destroy(Planning $planning)
    {
        $planning->delete();
        return response()->json([
            'type' => 'success',
            'text' => "planning is verwijderd."
        ]);
    }

    public function qryPlannings(Request $request){
        $text =  '%'.$request->request->get('text').'%';
        $date = $request->request->get('text2').'%';
        if($date != ''){
            $planningen  = DB::table('plannings')
                ->join('users', 'plannings.gebruikerID', '=', 'users.id')
                ->join('bedrijfs', 'users.bedrijfsID', '=', 'bedrijfs.id')
                ->join('nummerplaats', 'bedrijfs.id', '=', 'nummerplaats.bedrijfID')
                ->join('kades', 'plannings.kadeID', '=', 'kades.id')
                ->select('plannings.*','kades.kadenaam as kadenaam','bedrijfs.bedrijfsnaam as bedrijfsnaam', 'users.voornaam as voornaam', 'users.naam as naam','nummerplaats.plaatcombinatie as plaatcombinatie')
                ->where(function ($query) use ($text) {
                    $query->where('bedrijfsnaam', 'like', $text)
                        ->orwhere('volledigeNaam', 'like', $text)
                        ->orwhere('kadenaam', 'like', $text)
                        ->orwhere('proces', 'like', $text);

                })
                ->where('startTijd','like',$date)
                ->get();

        }
        else{
            $planningen  = DB::table('plannings')
                ->join('users', 'plannings.gebruikerID', '=', 'users.id')
                ->join('bedrijfs', 'users.bedrijfsID', '=', 'bedrijfs.id')
                ->join('nummerplaats', 'bedrijfs.id', '=', 'nummerplaats.bedrijfID')
                ->join('kades', 'plannings.kadeID', '=', 'kades.id')
                ->select('plannings.*','kades.kadenaam as kadenaam','bedrijfs.bedrijfsnaam as bedrijfsnaam', 'users.voornaam as voornaam', 'users.naam as naam','nummerplaats.plaatcombinatie as plaatcombinatie')
                ->where(function ($query) use ($text) {
                    $query->where('bedrijfsnaam', 'like', $text)
                        ->orwhere('volledigeNaam', 'like', $text)
                        ->orwhere('kadenaam', 'like', $text)
                        ->orwhere('proces', 'like', $text);

                })
                ->get();

        }

        Json::dump($planningen);

        return $planningen;

    }

    public function qryPlanningsUsers()
    {

        $users = DB::table('users')
            ->where('isChauffeur','=',true)
            ->get();

        Json::dump($users);
        return $users;
    }
    public function qryPlanningsKades()
    {
        $kades = DB::table('kades')
            ->get();

        Json::dump($kades);
        return $kades;
    }




}

