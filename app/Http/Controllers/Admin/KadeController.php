<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Kade;
use Illuminate\Http\Request;

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Kade  $kade
     * @return \Illuminate\Http\Response
     */
    public function destroy(Kade $kade)
    {
        //
    }
}
