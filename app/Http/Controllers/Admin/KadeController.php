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
                'naam' => 'required|min:3|max:255',
                'land' => 'required|max:255',
                'gemeente' => 'required|max:255',
                'adres' => 'required|max:255',
                'latitude' => 'numeric',
                'longitude' => 'numeric',
                'bedrijf_id' => 'digits:1',
                'rol' => 'digits:1'
            ]);
            $kade = new Kade();
            $kade->kadenaam = $request->naam;
            $kade->land = $request->land;
            $kade->gemeente = $request->gemeente;
            $kade->adres = $request->adres;
            $kade->latitude = $request->latitude;
            $kade->longitude = $request->longitude;
            $status = $request->status;

            if ($status == "1"){
                $kade->status = "Vrij";
            }elseif($status == "2"){
                $kade->status = "Niet-vrij";
            }else{
                $kade->status = "Buiten gebruik";
            }

            $kade->save();
            return response()->json([
                'type' => 'success',
                'text' => "De kade <b> $kade->naam</b> is toegevoegd. "
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
            'naam' => 'required|min:3|max:255',
            'land' => 'required|max:255',
            'gemeente' => 'required|max:255',
            'adres' => 'required|max:255',
            'latitude' => 'numeric',
            'longitude' => 'numeric',
            'bedrijf_id' => 'digits:1',
            'rol' => 'digits:1'
        ]);

        $kade->kadenaam = $request->naam;
        $kade->land = $request->land;
        $kade->gemeente = $request->gemeente;
        $kade->adres = $request->adres;
        $kade->latitude = $request->latitude;
        $kade->longitude = $request->longitude;
        $status = $request->status;

        if ($status == "1"){
            $kade->status = "Vrij";
        }elseif($status == "2"){
            $kade->status = "Niet-vrij";
        }else{
            $kade->status = "Buiten gebruik";
        }

        $kade->save();
        return response()->json([
            'type' => 'success',
            'text' => "De kade <b>$kade->kadenaam</b> is aangepast. "
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
            'text' => "<b>De kade  $kade->kadenaam</b> is verwijderd."
        ]);
    }


    public function qryKades(Request $request){

        $text =  '%'.$request->request->get('text').'%';

        $kades = Kade::orderBy('kadeNaam')
            ->where(function ($query) use ($text) {
                $query->where('kadenaam', 'like', $text)
                    ->orwhere('status', 'like', $text)
                    ->orwhere('gemeente', 'like', $text);
            })
            ->get();





        return $kades;
    }
}
