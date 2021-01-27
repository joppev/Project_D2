<?php

namespace App\Http\Controllers\Admin;

use App\Bedrijf;
use App\User;
use App\Http\Controllers\Controller;
use Facades\App\Helpers\Json;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        return view('admin.user.users');


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect('admin/users');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $bedrijven = DB::table('bedrijfs')
            ->get();
        $this->validate($request,[
            'naam' => 'required|min:3',
            'voornaam' => 'required|min:3',
            'email' => 'required|email',
            'bedrijf_id' => 'digits:1',
            'rol' => 'digits:1'
        ]);

        $user = new User();

        $user->naam = $request->naam;
        $user->voornaam = $request->voornaam;
        $user->email = $request->email;
        $user->bedrijfsID = (int)$request->bedrijf_id;
        $rol = $request->rol;

        foreach( $bedrijven as $bedrijf){
            if($user->bedrijfsID === $bedrijf->id){
                $user->password = Hash::make($bedrijf->standaardWachtwoord) ;
            }

        }
        if($rol === "1"){
            $user->isChauffeur = false;
            $user->isLogistiek = false;
            $user->isReceptionist = true;
            $user->isAdmin = true;
        } elseif($rol === "2"){
            $user->isChauffeur = true;
            $user->isLogistiek = false;
            $user->isReceptionist = false;
            $user->isAdmin = false;
        } elseif($rol === "3"){
            $user->isChauffeur = false;
            $user->isLogistiek = false;
            $user->isReceptionist = true;
            $user->isAdmin = false;
        }
        else{
            $user->isChauffeur = false;
            $user->isLogistiek = true;
            $user->isReceptionist = false;
            $user->isAdmin = false;
        }

        $user->save();
        return response()->json([
            'type' => 'success',
            'text' => "Gebruiker <b>$user->voornaam $user->naam</b> is toegevoegd."
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return redirect('admin/users');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return redirect('admin/users');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {


        $this->validate($request,[
            'naam' => 'required|min:3',
            'voornaam' => 'required|min:3',
            'email' => 'required|email',
            'bedrijf_id' => 'digits:1',
            'rol' => 'digits:1'
        ]);

        $user->naam = $request->naam;
        $user->voornaam = $request->voornaam;
        $user->email = $request->email;
        $user->bedrijfsID = (int)$request->bedrijf_id;
        $rol = $request->rol;

        if($rol === "1"){
            $user->isChauffeur = false;
            $user->isLogistiek = false;
            $user->isReceptionist = true;
            $user->isAdmin = true;
        } elseif($rol === "2"){
            $user->isChauffeur = true;
            $user->isLogistiek = false;
            $user->isReceptionist = false;
            $user->isAdmin = false;
        } elseif($rol === "3"){
            $user->isChauffeur = false;
            $user->isLogistiek = false;
            $user->isReceptionist = true;
            $user->isAdmin = false;
        }
        else{
            $user->isChauffeur = false;
            $user->isLogistiek = true;
            $user->isReceptionist = false;
            $user->isAdmin = false;
        }
        $user->save();
        return response()->json([
            'type' => 'success',
            'text' => "Gebruiker <b>$user->voornaam $user->naam</b> is aangepast."
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {

        if ($user->id == Auth::id()){
            return response()->json([
                'type' => 'error',
                'text' => "Je kan jezelf niet verwijderen."
            ]);
        } elseif (! Auth::user()->isAdmin){
            if($user->isAdmin){
                return response()->json([
                    'type' => 'error',
                    'text' => "Je het geen bevoegdheid om een admin te verwijderen."
                ]);
            }
        }

        else{
            $user->delete();
            return response()->json([
                'type' => 'success',
                'text' => "De gebruiker <b>$user->voornaam $user->naam</b> is verwijderd."
            ]);
        }


    }

    public function qryUsers(){

        $users = DB::table('users')
            ->join('bedrijfs', 'users.bedrijfsID', '=', 'bedrijfs.id')
            ->select('users.*', 'bedrijfs.bedrijfsnaam')
            ->get();


        Json::dump($users);

        return $users;

    }

    public function qryUsers2()
    {
        $bedrijven = DB::table('bedrijfs')
            ->get();

        Json::dump($bedrijven);
        return $bedrijven;
    }
}
