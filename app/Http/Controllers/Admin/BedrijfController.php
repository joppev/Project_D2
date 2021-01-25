<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Bedrijf;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;

class BedrijfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.bedrijven.bedrijven');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('admin/bedrijven');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,
            ['bedrijfsnaam' => 'required|min:3',
                'standaardWachtwoord' => 'required|min:8'
            ]);

        $bedrijf = new Bedrijf();
        $bedrijf->bedrijfsnaam = $request->bedrijfsnaam;
        $bedrijf->standaardWachtwoord = $request->standaardWachtwoord;
        $bedrijf->save();
        return response()->json([
            'type' => 'success',
            'text' => "Het bedrijf <b>$bedrijf->bedrijfsnaam</b> is aangemaakt."
        ]);
    }


    /**
     * Display the specified resource.
     *
     * @param \App\Bedrijf $bedrijf
     * @return \Illuminate\Http\Response
     */
    public function show(Bedrijf $bedrijf)
    {
        return redirect('admin/bedrijven');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Bedrijf $bedrijf
     * @return \Illuminate\Http\Response
     */
    public function edit(Bedrijf $bedrijf)
    {
        return redirect('admin/bedrijven');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Bedrijf $bedrijf
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $bedrijf = Bedrijf::find($id);
        $this->validate($request, [
            'bedrijfsnaam' => 'required|min:3,' . $bedrijf->id,
            'standaardWachtwoord' => 'required|min:8'
        ]);

        $bedrijf->bedrijfsnaam = $request->bedrijfsnaam;
        $bedrijf->standaardWachtwoord = $request->standaardWachtwoord;
        $bedrijf->save();
        return response()->json([
            'type' => 'success',
            'text' => "Het bedrijf <b>$bedrijf->bedrijfsnaam</b> is geüpdatet."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Bedrijf $bedrijf
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bedrijf = Bedrijf::find($id);
        $bedrijf->delete();
        return response()->json([
            'type' => 'success',
            'text' => "Het bedrijf <b> $bedrijf->bedrijfsnaam</b> is verwijderd."
        ]);
    }

    public function qryBedrijven()
    {
        $bedrijven = Bedrijf::orderBy('bedrijfsnaam')
//            ->LeftJoin('nummerplaats', 'bedrijfs.id', '=', 'nummerplaats.bedrijfID')
            ->get();

        return $bedrijven;
    }
}
