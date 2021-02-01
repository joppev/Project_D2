<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InzichtenController extends Controller
{
    public function index()
    {
        return view('admin.inzichten.inzichten');
    }
}
