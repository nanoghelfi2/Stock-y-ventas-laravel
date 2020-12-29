@extends('layouts.app')
@section('tittle') Carro de compras @endsection

@section('content')

{{-- Aca manejamos los mensajes de errores y otros --}}
@if (session('success'))
<div class="alert alert-success d-flex justify-content-between align-items-center"> {{ session('success') }}  </div>
@endif
@if (session('danger'))
<div class="alert alert-danger d-flex justify-content-between align-items-center"> {{ session('danger') }}  </div>
@endif

@php
    $precioFinal = 0;
    $productosEnviar = '';
@endphp


{{-- Aca guardamos los diferentes datos traidos de la base de datos segun el ID (del chango) que pasamos en la URL  --}} 
@foreach ($datosChango as $chango)
    @php
    //datos chango
        $idChango = $chango->id;
        $estadoVenta = $chango->estadoVenta;
        $descuento = $chango->descuento;
        $lugarTemporal = $chango->lugarTemporal;
    //datos cliente
        $idCliente = $chango->cliente->id;
        $nombreCliente = $chango->cliente->nombreCliente;
        $contacto = $chango->cliente->contacto;
        $contacto2 = $chango->cliente->contactoDos;
        $lugar = $chango->cliente->lugar;
        $lugar2 = $chango->cliente->lugarDos;
    @endphp
@endforeach
<input type="hidden" id="idChango" value="{{ $idChango }}">
<input type="hidden" id="estadoVenta" value="{{ $estadoVenta }}">

{{-- Esto muestra el lugar de entrega, tomando como prioridad el lugar temporal --}}
@if ($lugarTemporal != '' & $lugarTemporal != NULL)
    @php
        $boton = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLugarTemporal">  Designar lugar temporal </button> ';
        $lugarEntrega = $lugarTemporal.'<br>'.$boton;
        $lugarFinalizar = $lugarTemporal;
    @endphp 
@else
    @if ($lugar != '' OR $lugar != NULL) 
        @php 
            $lugarEntrega = '<b>Localidad: </b>'.$lugar.'<br><b>Calles: </b>'.$lugar2.'<br>'.'<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLugarTemporal">  Designar lugar temporal </button> ';
            $lugarFinalizar = $lugar.' - '.$lugar2;
        @endphp    
    @else 
        @php
            $lugarEntrega = $lugarTemporal.'<br>'.'<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLugarTemporal">  Designar lugar temporal </button> ';
            $lugarFinalizar = $lugarTemporal;
        @endphp
    @endif
    @if ($lugarTemporal == '' & $lugarTemporal == NULL & $lugar == '' & $lugar == NULL & $lugar2 == '' & $lugar2 == NULL)
        @php
            $lugarEntrega = '<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalLugarTemporal">  Designar lugar temporal </button> ';
            $lugarFinalizar = 'No inidico ningun lugar de entrega';
        @endphp
    @endif
@endif    





{{-- Esto es el "Sub-menu", donde tenemos los botones de confirmacion y cambios de estado del chango --}}

<div class="d-flex justify-content-between align-items-center mb-5 pb-2 border-bottom border-dark">
    <h5 class="text-center">Carro numero:<br> {{ $idChango }}</h5> 
    @switch($estadoVenta)

        @case($estadoVenta == 'proceso')
        <div class="mr-2">
            <form action="{{ route('chango.cambioEstado', $idChango) }}" method="POST">
                @csrf
                @method('PUT')
                <button class="btn btn-primary mb-2 btn-block text-center btn-lg"><span class="text-center">  Confirmar pedido </span> </button>
            </form>

                
                <button type="button" class="btn btn-danger btn-block text-center" id="datosCliente" data-toggle="modal" data-target="#borrarChango"> 
                    Borrar carro
                </button> 
        </div>
            @break

        @case($estadoVenta == 'pendiente')
        <div class="mr-2">

            <button type="button" class="btn btn-success mb-2 btn-block text-center btn-lg" data-toggle="modal" data-target="#finalizarVenta">
                <span class="text-center">  Finalizar venta</span> 
            </button>

            <button type="button" class="btn btn-danger btn-block text-center" id="datosCliente" data-toggle="modal" data-target="#borrarChangoPendiente"> 
                Cancelar venta
            </button> 

        </div>
            @break            
    @endswitch
</div>



{{-- Este bloque es del MODAL para AGREGAR PRODUCTO al carrito --}}
<div class="container mb-4">
    <button type="button" class="btn btn-success btn-block btn-lg" data-toggle="modal" data-target="#botonNewProducto" id="btnAgregarProducto"> 
    Agregar producto </button>
</div>
<div class="modal fade" id="botonNewProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Busqueda de producto</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div id="cuerpoModal"> </div>

      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    
            <form action="{{ route('chango.agregar.producto', $idChango) }}" method="get" id="formProductoChango">
                @csrf
            <input type="hidden" name="estadoVenta" value="{{ $estadoVenta }}">
                    <div id="inputHidden">   </div>
                    <button type="submit" class="btn btn-success d-none" id="enviarFormProducto">Agregar producto</button>
                    <button type="button" class="btn btn-secondary d-none" id="remplazoEnviar"> Agregando... </button>
            </form>
      </div>
    
      </div>
    </div>
  </div>
{{-- Este bloque es del modal para AGREGAR PRODUCTO al carrito --}}





{{-- Esta es la tabla donde mostramos los productos del carrito  --}}
<table class="table table-sm border-bottom">
    <thead class="thead-dark">
      <tr>
        <th scope="col">Quitar</th>
        <th scope="col">Producto</th>
        <th scope="col">Cantidad</th>
        <th scope="col">Subtotal</th>
      </tr>
    </thead>
    
@foreach ($datosChango as $changoID)
    @foreach ($changoID->wonderlist as $producto)
    <tbody>
    <tr>
        <td class="align-middle">
            <form action="{{ route('chango.borrar.producto', $idChango) }} " method="POST">
            @method('DELETE')
            @csrf
            <input type="hidden" name="estadoVenta" value="{{ $estadoVenta }}">
            <input type="hidden" name="idPivote" value="{{ $producto->pivot->id }}">
            <input type="hidden" name="idWonder" value="{{ $producto->pivot->wonderlist_id }}">
            <input type="hidden" name="cantidad" value="{{ $producto->pivot->cantidad }}">
            <input type="hidden" name="unidades" value="{{ $producto->pivot->unidades }}">
                <button type="submit" class="btn btn-danger btn-sm rounded-circle btnBorrar"> 
                    X 
                </button>
            </form>
        </td>

        <th class="align-middle"> {{ $marca= $producto->marca }} <br> {{ $tipo= $producto->tipo }} </td>
        <td class="text-center align-middle"> {{ $cantidades= $producto->pivot->cantidad }} un.  <br> {{ $producto->pivot->unidades }} </td>
        <td class="text-center align-middle"> $ {{ $producto->pivot->subtotal }} </td>
    </tr>
    </tbody>
        @php
            $productosEnviar .= '<li>'.$marca.' ('.$tipo.') = '.$cantidades.'</li>';
            $precioFinal += $producto->pivot->subtotal;
        @endphp
    @endforeach
@endforeach
</table>

  <div class="text-right mr-4 mb-3">
    <b> Descuento: $ {{ $descuento }} </b> <br>
    <b> Precio total: $   {{ $precioFinal }}   </b>
    <h4 class="mt-2"> Precio final: $   {{ $precioFinal - $descuento }}   </h4>
  </div>

  

{{--   Cuadro de descuento  --}}
<center>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Realizar descuento
</button>
</center>
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modificador de precio final</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <center>
          <input type="hidden" name="precioTotal" id="precioTotal" value="{{ $precioFinal }}">
          <h5 id="moduloDesc">Calcular descuento</h5>
          <div id="mostrarModuloDesc">
          <b>Numero:</b>
              <input type="number" name="numero" id="numero" class="form-control mb-2" min="0"> 
          <b>Tipo de descuento: </b><br>
          <select name="tipo" id="tipo" class="form-control">  
              <option value="-"> - (Restar)     </option>
              <option value="-%"> % (Restar porcentaje) </option>
              <option value="+"> + (Sumar)      </option>
              <option value="+%"> % (Rumar porcentaje) </option>
          </select> <br>
          <b> Resultado: $ <span id="colocar"> {{ $precioFinal }} </span></b> <br><br>
          <div id="msj" class="d-none"> </div>
        </div>
      </center>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <form action="{{ route('chango.cambiar.descuento', $idChango) }}" method="POST">
          @csrf  @method('PUT')
        <input type="hidden" name="resultadoFinal" id="resultadoFinal" value=0>
        <button type="submit" class="btn btn-primary" id="botonDescontar"> Realizar descuento </button>
      </form>
      </div>
    </div>
  </div>
</div>




  <!-- MODAL PARA FINALIZAR VENTA  -->
  <div class="modal fade" id="finalizarVenta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Completar </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            <h5 class="text-center"> ¡Felicidades! <br> esta a punto de finalizar la venta </h5>

        <form action="{{ route('chango.finalizar.venta', $idChango) }}" method="POST">
            @csrf
            @method('DELETE')
                <div class="d-none"> 
            Cliente:    <input type="text" name="clienteEnviar" value="{{$nombreCliente}}"> <br>
            Lugar:      <input type="text" name="lugarEnviar" value="{{$lugarFinalizar}}"> <br>
            Productos:  <textarea name="productosEnviar"> {{$productosEnviar}} </textarea>  <br>
            <b> Precio final: <input type="number" name="precioEnviar" value="{{ $precioFinal-$descuento }}"> </b>
                </div>
            
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal"> Todavia no </button>
          <button type="submit" class="btn btn-success btn-lg" id="btnFinal">¡Finalizar venta!</button>
          <button type="button" class="btn btn-secondary btn-lg d-none" id="btnFinalRemplazo">Finalizando...</button>
            </form>
        </div>
      </div>
    </div>
  </div>




{{-- Este bloque es sobre el cliente  --}}

<div class="container border-top border-bottom border-top pt-2 pb-2 border-dark" style="margin-top:8%;"><center>   
    <h5>Cliente: {{ $nombreCliente }}</h5> 

    
    <button type="button" class="btn btn-secondary" id="datosCliente" data-toggle="modal" data-target="#modalDatos"> 
        Datos del cliente
    </button> 
    
    <button type="button" class="btn btn-warning" id="datosCliente" data-toggle="modal" data-target="#modalCambio"> 
        Cambiar de cliente
    </button> 

    <div class="mt-4"> <h5> Lugar de entrega: </h5> 
        <p style="font-size:120%;">
        @php
            echo $lugarEntrega
        @endphp
        </p>
    </div></center>
</div>






{{--   MODALES PARA CLIENTES   --}}
                {{--   MODAL PARA DATOS DE CLIENTE   --}}
<div class="modal fade" id="modalDatos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ $nombreCliente }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p style="font-size:120%;">
                <b> ID: </b> {{ $idCliente }} <br>
                <b> Contacto: </b> {{ $contacto }} <br>
                <b> Contacto-2: </b> {{ $contacto2 }} <br>
                <b> Localidad: </b> {{ $lugar }} <br>
                <b> Calle: </b> {{ $lugar2 }} <br>
                <b> Lugar temporal: </b> {{$lugarTemporal}}                
            </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">Ok</button>
        </div>
      </div>
    </div>
  </div>

                         {{--   MODAL PARA CAMBIAR DE CLIENTE   --}}
  <div class="modal fade" id="modalCambio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Cambio de cliente </h5> 
          <a href="{{ route('clientes') }}" class="btn btn-primary"> Agregar nuevo </a>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p>
                <center>
                <b style="font-size:120%;">Seleccione un cliente: </b>
            <form action="{{ route('chango.cambiar.cliente', $idChango) }}" method="POST">
            @csrf
            @method('PUT')
                <select class="form-control" name="idCliente">
                    <option value=""> Seleccione un cliente... </option>
                    @foreach ($datosClientes as $cliente)
                    <option value="{{ $cliente->id }}"> {{ $cliente->nombreCliente }} </option>    
                    @endforeach
                </select></center>
            </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secundary" data-dismiss="modal">Cancelar</button>
              <button type="sumbit" class="btn btn-success"> Realizar cambio </button>
          </form>
        </div>
      </div>
    </div>
  </div>

                         {{--   MODAL PARA CAMBIAR DE LUGAR TEMPORAL   --}}
  <div class="modal fade" id="modalLugarTemporal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Cambio de cliente </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p>
    <center>
                <b style="font-size:120%;">Escriba el lugar de entrega temporal: </b>
            <form action="{{ route('chango.cambiar.lugarTemporal', $idChango) }}" method="POST">
            @csrf
            @method('PUT')
                <input type="text" name="lugarTemporal" class="form-control"> 
    </center>
            </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secundary" data-dismiss="modal">Cancelar</button>
              <button type="sumbit" class="btn btn-primary"> Realizar cambio </button>
          </form>
        </div>
      </div>
    </div>
  </div>

                           {{--   MODAL BORRAR CHANGO   --}}
  <div class="modal fade" id="borrarChango" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Borrar chango </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p>
    <center>
                <b style="font-size:120%;">¿Estas seguro que quiere eliminar este chango? </b>
    </center>
            </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secundary" data-dismiss="modal">Cancelar</button>
            <form action="{{ route('chango.borrar', $idChango) }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="estadoVenta" value="proceso">
                <button type="submit" class="btn btn-danger btn-block text-center"><span class="text-center"> Borrar chango </span></button>
            </form> 
   
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="borrarChangoPendiente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel"> Borrar chango </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <p>
    <center>
                <b style="font-size:120%;">¿Estas seguro que quiere eliminar este chango? </b>
    </center>
            </p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <form action="{{ route('chango.borrar', $idChango) }}" method="POST">
            @csrf
            @method('DELETE')
            <input type="hidden" name="estadoVenta" value="pendiente">
            <button type="submit" class="btn btn-danger btn-block text-center" id="btnCancelarVenta">
              <span class="text-center"> Cancelar venta </span>
            </button>
            <button type="button" class="btn btn-secondary btn-block text-center d-none" id="btnCancelarVentaRemplazo">
              <span class="text-center"> Cancelando </span>
            </button>
        </form> 
   
        </div>
      </div>
    </div>
  </div>


  @endsection





@section('scripts')
<script src="/js/wonderlist.js"></script>
<script src="/js/chango.js"></script>
@endsection