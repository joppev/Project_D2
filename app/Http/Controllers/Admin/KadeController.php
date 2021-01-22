<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Kade;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KadeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.kade.kades');
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
        {
            $this->validate($request,[
                'naam' => 'required|min:3,'

            ]);
            $kade = new Kade();
            $kade->naam = $request->naam;
            $kade->land = $request->land;
            $kade->gemeente = $request->gemeente;
            $kade->adres = $request->adres;
            $kade->latitude = $request->latitude;
            $kade->longitude = $request->longitude;
            $kade->status = $request->status;

            $kade->save();
            return response()->json([
                'type' => 'success',
                'text' => "De kade <b> $kade->naam</b> is Toegevoegd. "
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Kade  $kade
     * @return \Illuminate\Http\Response
     */
    public function show(Kade $kade)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Kade  $kade
     * @return \Illuminate\Http\Response
     */
    public function edit(Kade $kade)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Kade  $kade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Kade $kade)
    {
        $this->validate($request,[
            'naam' => 'required|min:3,' . $kade->id

        ]);

        $kade->naam = $request->naam;
        $kade->land = $request->land;
        $kade->gemeente = $request->gemeente;
        $kade->adres = $request->adres;
        $kade->latitude = $request->latitude;
        $kade->longitude = $request->longitude;
        $kade->status = $request->status;

        $kade->save();
        return response()->json([
            'type' => 'success',
            'text' => "De kade <b>$kade->naam</b> is aangepast. "
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kade  $kade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kade $kade)
    {
        $kade->delete();
        return response()->json([
            'type' => 'success',
            'text' => "<b> $kade->naam</b> is verwijderd."
        ]);
    }


    public function qryKades(){

        $kades = DB::table('kades')

            ->get();


        Json::dump($kades);

        return $kades;

    }
}
