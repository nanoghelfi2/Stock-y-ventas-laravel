<?php

namespace App\Http\Controllers;

use App\Models\Chango;
use App\Models\Wonderlist;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $faltanteArtesanal =    Wonderlist::where('stock', '<', '6' )
                                                    ->where('tipoCerveza', '=', 'artesanal')
                                                    ->orderBy('stock', 'asc')
                                                    ->get();
        $faltanteIndustrial =   Wonderlist::where('stock', '<', '13' )
                                                    ->where('tipoCerveza', '=', 'industrial')
                                                    ->orderBy('stock', 'asc')
                                                    ->get();
        $faltanteOtro =         Wonderlist::where('stock', '<', '6' )
                                                    ->where('tipoCerveza', '=', 'otro')
                                                    ->orderBy('stock', 'asc')
                                                    ->get();


         $changoProceso =        Chango::all()->where('estadoVenta', '=', 'proceso'); 
         
         $changoPendiente =        Chango::all()->where('estadoVenta', '=', 'pendiente');
                                                    
                                                    
        return view('home', compact('faltanteArtesanal', 'faltanteIndustrial', 'faltanteOtro', 'changoProceso', 'changoPendiente'));
    }
}
