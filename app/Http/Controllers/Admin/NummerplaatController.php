<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Nummerplaat;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NummerplaatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.nummerplaat.nummerplaat');
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

            'plaatcombinatie' => 'required|regex:/[1-2]{1}-[a-z]{3}-[0-9]{3}$/i',
            'bedrijf_id' => 'digits:1',

        ]);



        $nummerplaat = new Nummerplaat();
        $nummerplaat->plaatcombinatie = $request->plaatcombinatie;
        $nummerplaat->bedrijfID = $request->bedrijf_id;



        $nummerplaat->save();
        return response()->json([
            'type' => 'success',
            'text' => "De nummerplaat <b>$nummerplaat->plaatcombinatie </b> is toegevoegd. "
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Nummerplaat  $nummerplaat
     * @return \Illuminate\Http\Response
     */
    public function show(Nummerplaat $nummerplaat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Nummerplaat  $nummerplaat
     * @return \Illuminate\Http\Response
     */
    public function edit(Nummerplaat $nummerplaat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Nummerplaat  $nummerplaat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Nummerplaat $nummerplaat)
    {

        $this->validate($request,[
            'plaatcombinatie' => 'required|min:3',
            'bedrijf_id' => 'digits:1',

        ]);

        $nummerplaat->plaatcombinatie = $request->plaatcombinatie;
        $nummerplaat->bedrijfID = $request->bedrijf_id;

        $nummerplaat->save();
        return response()->json([
            'type' => 'success',
            'text' => "De nummerplaat <b>$nummerplaat->plaatcombinatie </b> is aangepast."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Nummerplaat  $nummerplaat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Nummerplaat $nummerplaat)
    {
        $nummerplaat->delete();
        return response()->json([
            'type' => 'success',
            'text' => "De nummerplaat <b>$nummerplaat->plaatcombinatie</b> is verwijderd."
        ]);
    }

    public function qryNummerplaats(Request $request){
        $text =  '%'.$request->request->get('text').'%';

        $nrp = DB::table('nummerplaats')
            ->join('bedrijfs','nummerplaats.bedrijfID','=',"bedrijfs.id")
            ->select('nummerplaats.*','bedrijfs.bedrijfsnaam')
            ->where(function ($query) use ($text) {
                $query->where('plaatcombinatie', 'like', $text)
                    ->orwhere('bedrijfsnaam', 'like', $text);
            })
            ->get();
        Json::dump($nrp);

        return $nrp;
    }
    public function qryNummerplaats2(Request $request)
    {
        $bedrijven = DB::table('bedrijfs')
            ->get();

        Json::dump($bedrijven);
        return $bedrijven;
    }
}
