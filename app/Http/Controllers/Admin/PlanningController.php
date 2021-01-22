<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Planning;
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Planning  $planning
     * @return \Illuminate\Http\Response
     */
    public function destroy(Planning $planning)
    {
        //
    }

    public function qryPlannings(){

        $planningen = Planning::orderBy('startTijd')
            ->Join('tijd_tabels', 'plannings.tijdTabelID', '=', 'tijd_tabels.id')
            ->Join('gebruikers', 'plannings.gebruikerID', '=', 'gebruikers.id')
            ->Join('bedrijfs', 'gebruikers.bedrijfs_id', '=', 'bedrijfs.id')
            ->Join('nummerplaats', 'bedrijfs.id', '=', 'nummerplaats.bedrijfID')
            ->Join('kades', 'plannings.kadeID', '=', 'kades.id')
            ->get();


        Json::dump($planningen);

        return $planningen;

    }
}
