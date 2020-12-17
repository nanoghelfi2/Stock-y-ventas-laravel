@extends('layouts.app')
@section('tittle') Ventas @endsection

@section('content')

@foreach ($allVentas as $venta)
  
@endforeach

<h2> Estas son todas las ventas.</h2>
<p> Click en cada venta para obtener mas informacion.</p>

<h3> Ventas de hoy </h3>
@foreach ($ventasHoy as $venta)
        <div class="d-flex justify-content-between border-bottom-0
        text-light bg-success 
        pt-3 pb-2 mt-3 mb-3" 
        id="{{ $venta->id }}">
            <div class="col">
                <p class="text-center">  {{ $venta->fecha }}  </p>
            </div>
            <div class="col">
                <p class="text-center border-left border-right"> {{ $venta->nombreCliente }}  <br>
                $ {{ $venta->valorVenta }} </p>
            </div>
            <div class="col">
                <center>
                    <button type="button" class="btn btn-light verVenta" 
                    id="{{ $venta->id }}" 
                    data-toggle="modal" 
                    data-target="#exampleModal">
                        Detalles
                    </button>
                </center>
            </div>
        </div>
@endforeach

<h3> Ventas de los ultimos 7 dias </h3>
@foreach ($ventasSemana as $venta)
        <div class="d-flex justify-content-between border-bottom-0
        text-light bg-primary
        pt-3 pb-2 mt-3 mb-3" 
        id="{{ $venta->id }}">
            <div class="col">
                <p class="text-center">  {{ $venta->fecha }}  </p>
            </div>
            <div class="col">
                <p class="text-center border-left border-right"> {{ $venta->nombreCliente }}  <br>
                $ {{ $venta->valorVenta }} </p>
            </div>
            <div class="col">
                <center>
                    <button type="button" class="btn btn-light verVenta" 
                    id="{{ $venta->id }}" 
                    data-toggle="modal" 
                    data-target="#exampleModal">
                        Detalles
                    </button>
                </center>
            </div>
        </div>
@endforeach


<h3> Resto de las ventas </h3>
@foreach ($allVentas as $venta)
        <div class="d-flex justify-content-between border-bottom-0
        text-light bg-dark 
        pt-3 pb-2 mt-3" 
        id="{{ $venta->id }}">
            <div class="col">
                <p class="text-center">  {{ $venta->fecha }}  </p>
            </div>
            <div class="col">
                <p class="text-center border-left border-right"> {{ $venta->nombreCliente }}  <br>
                $ {{ $venta->valorVenta }} </p>
            </div>
            <div class="col">
                <center>
                    <button type="button" class="btn btn-light verVenta" 
                    id="{{ $venta->id }}" 
                    data-toggle="modal" 
                    data-target="#exampleModal">
                        Detalles
                    </button>
                </center>
            </div>
        </div>
@endforeach

<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
    <div id="pegarData"> </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" aria-label="Close"> Cerrar </button>
      </div> 
</div>
</div>
</div>



  


@endsection


@section('scripts')

<script src="/js/venta.js"></script>
<script src="/js/pruebas/edit.js"></script>

@endsection