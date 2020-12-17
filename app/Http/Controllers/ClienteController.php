<?php

namespace App\Http\Controllers;

use App\Models\Chango;
use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{

    public function vistaCliente(){
        $allClientes = Cliente::orderBy('nombreCliente', 'asc')->where('id', '!=', 1)->get();

        return view('clientes', compact('allClientes'));
    }

    public function modalCliente($id){
        $mostrarCliente = Cliente::where('id', '=', $id)->get();

        return view('cliente/modal', compact('mostrarCliente'));
    }

    public function borrarCliente($id){
        //Con este bloque, comprobamos si el cliente tiene un carro, en tal caso tendremos que resolverlo antes de borrar el cliente
        $chango = Chango::where('cliente_id', '=', $id)->get();
        foreach($chango as $ch){
            $changoID = $ch->id;
        }
        if(!isset($changoID)){
            $clienteBorrar = Cliente::findOrFail($id);
            $clienteBorrar->delete();
            return back()->with('success', 'Cliente ELIMINADO correctamente.');
        }else{
            return back()->with('danger', 'Este cliente tiene CARRO(S) en proceso, finalize o borre tal carro.');
        }
    }
    public function agregarCliente(Request $request){
        $cliente = new Cliente();
        $cliente->nombreCliente = $request->nombre;
        $cliente->contacto = $request->contacto;
        $cliente->contactoDos = $request->contactoDos;
        $cliente->lugar = $request->lugar;
        $cliente->lugarDos = $request->lugarDos;
        $cliente->save();

        return back()->with('success', 'Cliente "'.$request->nombre.'" agregado correctamente');
    }
    public function editarCliente($id, Request $request){
        $cliente = Cliente::findOrFail($id);
        $cliente->nombreCliente = $request->nombre;
        $cliente->contacto = $request->contacto;
        $cliente->contactoDos = $request->contactoDos;
        $cliente->lugar = $request->lugar;
        $cliente->lugarDos = $request->lugarDos;
        $cliente->save();
        
        return back()->with('success', 'Cliente editado correctamente');
    }


}
