@extends('layouts.app')
@section('tittle') Panel principal @endsection

{{-- LOGICAS --}}
@foreach ($changoPendiente as $pp)
@php
    $lugarTemporal = $pp->lugarTemporal;
    $lugar1 = $pp->nombreCliente;
@endphp
@endforeach

@section('content')
{{-- MODAL --}}
<div class="modal fade" id="staticBackdrop" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Carrito de compras</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <button type="button" class="btn btn-success btn-lg btn-block" id="botonNewChango"> Nuevo carro </button>

            <div class="border-top mt-4 text-center"> <b>Carros empezados: </b></div>

                @foreach ($changoProceso as $item)
                <a href="{{ route('chango', $item)}}">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page">Carro N°: {{$item->id}}</li>
                <li class="breadcrumb-item active" aria-current="page">Cliente: {{$item->cliente->nombreCliente}}</li>
              </ol>
            </nav></a>
                @endforeach

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

      </div>
    </div>
  </div>
</div>

<div class="container">    
  
    <div class="row justify-content-center align-items-center">

        <button 
        type="button" 
        class="mb-2 text-center text-white border rounded-circle bg-success d-flex justify-content-center flex-wrap" 
        data-toggle="modal" 
        data-target="#staticBackdrop" 
        style="width:220px; height:220px;">

                    <h1 class="display-1 align-self-center"> $  </h1>
                    <p  class="" style="width: 100%; font-size:110%;"> NUEVA VENTA </p> 

        </button>

    <a href="{{ route('wonderlist') }}"> 
        <div class="
            mb-2 
            text-center text-white 
            border rounded-circle bg-primary d-flex 
            justify-content-center flex-wrap" 
            style="width:200px; height:200px; ">
                    <img src="/img/casa.png" class="align-self-center" style="max-width: 40%"> 
                    <p  class="" style="width: 100%; font-size:110%;"> 
                        WONDERLIST <br> (stock y precios) 
                    </p> 
        </div> </a>

        <a href="{{ route('ventas') }}"> 
            <div class=" 
            mb-2 
            text-center text-white 
            border rounded-circle bg-primary d-flex 
            justify-content-center flex-wrap" 
            style="width:180px; height:180px;">
                    <h1 class="display-1 align-self-center"> $  </h1>
                    <p  class="" style="width: 100%; font-size:110%;"> VER VENTAS </p> 
            </div> </a>


            <a href="{{ route('clientes') }}"> 
              <div class="
                  mb-2 
                  text-center text-white 
                  border rounded-circle bg-primary d-flex 
                  justify-content-center flex-wrap" 
                  style="width:180px; height:180px; ">
                          <img src="/img/cliente.png" class="align-self-center" style="max-width: 55%"> 
                          <p  class="" style="width: 100%; font-size:110%;"> 
                              CLIENTES
                          </p> 
              </div> </a>



            <div class="container mt-3">
                <div class="text-center mt-1"> <h3 class="bg-warning text-dark p-2"> Entregas pendientes </h3></div>
                <div class="p-2">
                  @foreach ($changoPendiente as $item)
                      
                          @if ($item->lugarTemporal == '' OR $item->lugarTemporal == 'null')
                              @php
                                $lugarEntrega = $item->cliente->lugar.' - '.$item->cliente->lugarDos
                              @endphp
                          @else
                              @php
                                $lugarEntrega = $item->lugarTemporal;
                              @endphp
                          @endif

                  <a href="{{ route('chango', $item)}}">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item" aria-current="page"><b> Cliente: {{$item->cliente->nombreCliente }} </b></li>
                  <li class="breadcrumb-item active" aria-current="page"> <b> {{ $lugarEntrega }} </b></li>
                </ol>
              </nav>
                </a>

                  @endforeach

                </div>
            </div>


            <div class="container mt-5 border-dark border-top pt-5 ">
              <div class="text-center"> <h3 class="bg-danger text-white p-2"> Poco stock </h3></div>
                <div class="card-body">
                  
                      <div class="mb-5">
                        <h4 class="text-center border p-1 breadcrumb"> Industriales </h4>
                            @foreach ($faltanteIndustrial as $producto)
                                <div class="d-flex bd-highlight text-dark border-top border-bottom border-dark p-2 mt-2">
                                  <div class="flex-fill">
                                      {{ $producto->marca }}<br>
                                      {{ $producto->tipo }}
                                  </div>
                                  <div class="flex-fill text-right">
                                    <ins>Stock </ins><br>
                                      <b>{{ $producto->stock }}</b>
                                  </div>
                              </div>
                            @endforeach
                      </div>
                  
                      <div class="mb-5">
                        <h4 class="text-center border p-1 breadcrumb">Artesanales</h4>
                              @foreach ($faltanteArtesanal as $producto)
                              <div class="d-flex bd-highlight text-dark border-top border-bottom border-dark p-2 mt-2">
                                  <div class="flex-fill bd-highlight">
                                      {{ $producto->marca }}<br>
                                      {{ $producto->tipo }}
                                  </div>
                                  <div class="flex-fill bd-highlight text-right">
                                    <ins>Stock</ins><br>
                                      <b>{{ $producto->stock }}</b>
                                  </div>
                              </div>
                            @endforeach
                      </div>

                      <div class="mb-5">
                        <h4 class="text-center border p-1 breadcrumb">Otros productos</h4>
                                @foreach ($faltanteOtro as $producto)
                                <div class="d-flex bd-highlight text-dark border-top border-bottom border-dark p-2">
                                  <div class="flex-fill bd-highlight">
                                      {{ $producto->marca }}<br>
                                      {{ $producto->tipo }}
                                  </div>
                                  <div class="flex-fill bd-highlight text-right">
                                    <ins>Stock</ins><br>
                                      <b>{{ $producto->stock }}</b>
                                  </div>
                              </div>
                              @endforeach
                      </div>
                      
                </div>
            </div>
        </div>



    </div>
</div>

@endsection

@section('scripts')
<script src="/js/pruebas/edit.js"></script>
<script src="/js/wonderlist.js"></script>
<script src="/js/chango.js"></script>
@endsection
