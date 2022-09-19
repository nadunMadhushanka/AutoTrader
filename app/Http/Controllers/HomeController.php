<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use infrastructure\Facades\BybitFacade;

class HomeController extends Controller
{
    public function index(){
        $currpaire = BybitFacade::getTickers();
        return view('home')->with('currpair',$currpaire);
    }
   
}
