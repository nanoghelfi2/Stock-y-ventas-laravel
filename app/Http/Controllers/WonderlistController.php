<?php

namespace App\Http\Controllers;

use App;
use App\Models\Wonderlist;
use Illuminate\Http\Request;

class WonderlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    //WONDERLIST
    public function allProducts($marca = 'todas'){
        if($marca == 'todas'){
        $productos = App\Models\Wonderlist::orderBy('marca')->get();
        }else{
        $productos = App\Models\Wonderlist::where('marca', $marca)->get(); 
        }

        $marcas = App\Models\Wonderlist::all('marca'); // ESTO ES DEL AJAX y se va a poder borrar, porque ahora lo uso de ejemplo
        $marcas = $marcas->unique('marca');

    
        return view('wonderlist', compact('productos', 'marcas'));
    }

    //AGREGAR
    public function vistaAgregar(){
        $marcas = App\Models\Wonderlist::all('marca'); // ESTO ES DEL AJAX
        $marcas = $marcas->unique('marca');

        return view('wonderlist/agregar', compact('marcas'));
    }

    public function agregarWonderlist(Request $request){
        //VERIFICAR MARCA
        if($request->nuevaMarca == NULL && $request->existenteMarca == NULL){  //Aca pregunto si estan los dos campos vacios
            $request->validate([
                'existenteMarca' => 'required',
                'nuevaMarca' => 'required'  ]);
        }else if($request->nuevaMarca != NULL && $request->existenteMarca != NULL){  //Aca pregunto si estan los dos campos llenos
            return back()->with('Error', 'Debe rellenar un solo campo de las MARCAS de cerveza');
        }   
        if($request->existenteMarca != NULL){
                    $marca = $request->existenteMarca;
                    }else{  $marca = $request->nuevaMarca;   }


        $request->validate([ 'nuevoTipo' => 'required'  ]); //Verifico que no este vacio el input tipo

        //Guardar en BBDD
        $nuevoProducto = new Wonderlist();
        $nuevoProducto->marca = $marca;
        $nuevoProducto->tipo = $request->nuevoTipo;
        $nuevoProducto->precioCompra = $request->precioCompra;
        $nuevoProducto->unidadCompra = $request->unidadCompra;
        $nuevoProducto->precioVenta = $request->precioVenta; 
        $nuevoProducto->precioPack = $request->precioPack;
        $nuevoProducto->stock = $request->stock;
        $nuevoProducto->tipoCerveza = $request->tipoCerveza;
        $nuevoProducto->save();

        return back()->with('success', 'Producto agregado.');
    }
    //EDITAR
    public function vistaEditar($item){
        $marcas = App\Models\Wonderlist::all('marca');
        $marcas = $marcas->unique('marca');
        $datos = App\Models\Wonderlist::findOrFail($item);

        return view('wonderlist.editar', compact('marcas', 'datos'));
    }
    public function editarWonderlist(Request $request, $id){
        if($request->nuevaMarca == NULL && $request->existenteMarca == NULL){  //Aca pregunto si estan los dos campos vacios
            $request->validate([
                'existenteMarca' => 'required',
                'nuevaMarca' => 'required'  ]);
        }else if($request->nuevaMarca != NULL && $request->existenteMarca != NULL){  //Aca pregunto si estan los dos campos llenos
            return back()->with('Error', 'Debe rellenar un solo campo de las MARCAS de cerveza');
        }   
        if($request->existenteMarca != NULL){
                    $marca = $request->existenteMarca;
                    }else{  $marca = $request->nuevaMarca;   }


        $request->validate([ 'nuevoTipo' => 'required'  ]);
        
        $productoEditar = App\Models\Wonderlist::findOrFail($id);
        $productoEditar->marca = $marca;
        $productoEditar->tipo = $request->nuevoTipo;
        $productoEditar->precioCompra = $request->precioCompra;
        $productoEditar->unidadCompra = $request->unidadCompra;
        $productoEditar->precioVenta = $request->precioVenta;
        $productoEditar->precioPack = $request->precioPack;
        $productoEditar->stock = $request->stock;
        $productoEditar->tipoCerveza = $request->tipoCerveza;

        $productoEditar->save();

        return back()->with('success', 'Producto editado.');
    }
    //BORRAR
    public function vistaBorrar($item){
        $productoEliminar = App\Models\Wonderlist::findOrFail($item);
        $productoEliminar->delete();


        return back()->with('success', 'Producto borrado.');
    }

    public function mostrarModal($id){
        $productoEliminar = App\Models\Wonderlist::where('id', $id)->get();

        return view('wonderlist/modal', compact('productoEliminar')); 
    }

    //VER x producto
    public function verProducto($id){
        $verProducto = App\Models\Wonderlist::findOrFail($id);

        return view('wonderlist/ver', compact('verProducto'));
    }

    public function tiposAjax($marca){
        $tipos = App\Models\Wonderlist::where('marca', 'LIKE',  '%'.$marca.'%')->orWhere('tipo', 'LIKE',  '%'.$marca.'%') ->get();
        return $tipos;
    }
    public function traerDatosID($id){
        $producto = App\Models\Wonderlist::where('id', '=',$id)->get();
        return $producto;
    }

}
