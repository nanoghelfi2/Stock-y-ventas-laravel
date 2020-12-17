<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function vistaVentas(){

        $ventasHoy = Venta::latest('fecha')->where('fecha', '>', Carbon::now()->subDay())->get();

        $ventasSemana = Venta::latest('fecha')->where('fecha', '>', Carbon::now()->subDays(7))->where('fecha', '<', Carbon::now()->subDay())->get();

        $allVentas = Venta::latest('fecha')->where('fecha', '<', Carbon::now()->subDays(7))->get();

        return view('ventas', compact('allVentas', 'ventasHoy', 'ventasSemana'));
    }
    public function vistaVenta($id){
        $verVenta = Venta::where('id', '=', $id)->get();
        return view('venta/venta', compact('verVenta'));
    }
    public function prueba(){
        $allVentas = Venta::all();
        dd($allVentas->fecha);
        return compact('allVentas');
    }


}
