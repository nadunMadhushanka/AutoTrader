<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use infrastructure\Facades\BybitFacade;

class HomeController extends Controller
{

    // this is the starting function
    public function index(){
        $currpaire = BybitFacade::getTickers();
        return view('home')->with('currpair',$currpaire);
    }
   
}
