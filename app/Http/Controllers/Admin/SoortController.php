<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Soort;
use Illuminate\Http\Request;

class SoortController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.proces.proces');
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
            'naam' => 'required|min:3|unique:soorts,soortNaam'
        ]);

        $soort = new Soort();
        $soort->soortNaam = $request->naam;
        $soort->save();
        return response()->json([
            'type' => 'success',
            'text' => "Het proces <b>$soort->soortNaam</b> is toegevoegd."
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Soort  $soort
     * @return \Illuminate\Http\Response
     */
    public function show(Soort $soort)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Soort  $soort
     * @return \Illuminate\Http\Response
     */
    public function edit(Soort $soort)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Soort  $soort
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Soort $soort)
    {
        $this->validate($request,[
            'naam' => 'required|min:3|unique:soorts,soortNaam,' . $soort->id
        ]);

        $soort->soortNaam = $request->naam;
        $soort->save();
        return response()->json([
            'type' => 'success',
            'text' => "Het proces <b>$soort->soortNaam</b> is aangepast."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Soort  $soort
     * @return \Illuminate\Http\Response
     */
    public function destroy(Soort $soort)
    {
        $soort->delete();
        return response()->json([
            'type' => 'success',
            'text' => "het proces <b>$soort->soortNaam</b> is verwijderd."
        ]);
    }

    public function qrySoorts()
    {
        $soorts = Soort::orderBy('soortNaam')

            ->get();
        return $soorts;
    }

}
