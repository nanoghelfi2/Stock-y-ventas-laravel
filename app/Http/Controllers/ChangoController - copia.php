<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Cliente;
use App\Models\Chango;
use App\Models\Wonderlist;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ChangoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function paginaPrincipal($id){
        $datosChango = Chango::where('id', '=', $id)->get();
        $datosClientes = Cliente::select('id', 'nombreCliente')->get();

        return view('chango', compact('datosChango', 'datosClientes'));
    }
    public function paginaPrincipal2($id){
        $datosChango = Chango::where('id', '=', $id)->get();
        $datosClientes = Cliente::select('id', 'nombreCliente')->get();

        return compact('datosChango', 'datosClientes');
    }

    public function nuevoChango(){
        $chango = new Chango();
        $chango->save();
        $idCreado = $chango->id;

        return $idCreado;
    }




    //Cambio de cliente
    public function cambiarCliente($id, Request $request){
        $idCliente = $request->idCliente;
        if($idCliente == '' OR $idCliente == NULL){
            return back()->with('danger', 'Debe seleccionar un cliente para realizar este cambio');
        }
        $cambioChango = Chango::find($id);
        $cambioChango->cliente_id = $idCliente;
        $cambioChango->save();

        return back()->with('success', 'Cliente actualizado');
    }



    //Cambio de lugar temporal
    public function lugarTemporal($id, Request $request){
        $lugarTemporal = $request->lugarTemporal;
        $cambioChango = Chango::find($id);
        $cambioChango->lugarTemporal = $lugarTemporal;
        $cambioChango->save();

        return back()->with('success', 'Se asigno un nuevo lugar temporal');
    }






    //AGREGAR PRODUCTO
public function agregarAlChango($id, Request $request){
                            // LOGICAS 

        //Logica para que la cantidad que viene, no sea mayor al del stock
if($request->stockActual < $request->cantidad OR $request->cantidad < 0){
    return back()->with('danger', 'La cantidad no puede ser mayor al del stock. Ni menor a 0');
}else{
    if($request->unidades == 'sixpack'){
        $cantidadVerificada = $request->cantidad * 6;
    }else{
        $cantidadVerificada = $request->cantidad;
    }
}
        //Logica para el estado de chango y quitar el Stock
if($request->estadoVenta == 'pendiente'){
    $stockTotal = $request->stockActual - $cantidadVerificada;
    $quitarStock = Wonderlist::findOrFail($request->idProducto);
    $quitarStock->stock = $stockTotal;
    $quitarStock->save();
}
        //logica para ver si es un sixpack o una unidad para almacenar en la tabla pivote
if($request->unidades == 'unidad' OR $request->unidades == 'sixpack'){
    $unidades = $request->unidades;
}else{ 
    $unidades = 'unidad'; 
}
                            // LOGICAS (fin)


        $producto = Chango::find($id);
        $idProducto = $request->idProducto;
        $cantidad = $cantidadVerificada;
        $subtotal = $request->subtotal;

        $producto->wonderlist()->attach([$idProducto], ['cantidad' => $cantidad,'unidades' => $unidades,'subtotal' => $subtotal]);

        return back();
    }


    public function mostrarModal(){        
        return view('chango/modalNP');
    }



    //Cambio de estado
    public function cambioEstado($id){
        $cambioEstado = Chango::findOrFail($id);

        $ppr = $cambioEstado->wonderlist()->wherePivot('chango_id', '=', $id)->get();

        foreach($ppr as $pr){
        $quitarStock = Wonderlist::findOrFail($pr->id);
            if($quitarStock->stock < $pr->pivot->cantidad){
                return back()->with('danger', 'Uno de los productos tiene mas cantidad de lo que hay de stock');
            }
        } 
        foreach($ppr as $pr){
            $quitarStock = Wonderlist::findOrFail($pr->id);
            $quitarStock->stock = $quitarStock->stock - $pr->pivot->cantidad;
            $quitarStock->save();
        }

        $cambioEstado->estadoVenta = 'pendiente';
        $cambioEstado->save();

        return back()->with('success', 'Bien! solo queda entregar el pedido.');
    }





    //BORRAR
    public function changoBorrar($item, Request $request){
        $estado_venta =  $request->estadoVenta;
        $productoEliminar = Chango::findOrFail($item);

            if($estado_venta == 'pendiente'){ //Devuelve el stock si la venta estaba en proceso
               $ppr = $productoEliminar->wonderlist()->wherePivot('chango_id', '=', $item)->get();
                foreach($ppr as $pr){
                    $quitarStock = Wonderlist::findOrFail($pr->id);
                    $quitarStock->stock = $quitarStock->stock + $pr->pivot->cantidad;
                    $quitarStock->save();
                } 
            }

        $productoEliminar = Chango::findOrFail($item);
        $productoEliminar->delete(); //Borra el chango 
        $productoEliminar->wonderlist()->wherePivot('chango_id', '=', $item)->detach(); //Borra el producto en la tabla pivote 

        return redirect('home'); 
    }

    //FINALIZAR CHANGO
    public function finalizarVenta($id, Request $request){
        $nombreCliente = $request->clienteEnviar;
        $lugarEntrega = $request->lugarEnviar;
        $productos = $request->productosEnviar;
        $precio = $request->precioEnviar;
        $fecha = Carbon::now();

    
        $venta = new Venta();
        $venta->nombreCliente = $nombreCliente;
        $venta->productosVendidos = $productos;
        $venta->valorVenta = $precio;
        $venta->lugar = $lugarEntrega;
        $venta->fecha = $fecha;
        $venta->save(); 

        $productoEliminar = Chango::findOrFail($id);
        $productoEliminar->delete(); //Borra el chango 
        $productoEliminar->wonderlist()->wherePivot('chango_id', '=', $id)->detach(); //Borra el producto en la tabla pivote 

        return redirect('ventas');
    }





//Borrar producto
    public function borrarProducto($idChango, Request $request){
        $estado_venta = $request->estadoVenta;
        $id_pivote = $request->idPivote; 
        $id_wonder = $request->idWonder; 
        $cantidad_pivote = $request->cantidad;
        $unidad_pivote = $request->unidades;
        
     $producto = Chango::find($idChango);    

    if($unidad_pivote == 'sixpack'){ //Traigo las cantidades y las unidades, si es sixpack, multiplico x 6 la unidad
        $cantidadVerificada = $cantidad_pivote * 6;
    }else{
        $cantidadVerificada = $cantidad_pivote; } 

    if($estado_venta == 'pendiente'){
        $quitarStock = Wonderlist::findOrFail($id_wonder);
        $quitarStock->stock = $quitarStock->stock + $cantidadVerificada;
        $quitarStock->save();
    } 
   

        $producto->wonderlist()->wherePivot('id', '=', $id_pivote)->detach();
        return back();
    }


}
