@extends('layouts.app')
@section('tittle') Detalles de producto @endsection

@section('content')
@php
   $costoActual = $verProducto->precioCompra;
@endphp

@switch($verProducto->unidadCompra)

    @case($verProducto->unidadCompra == 'unidad')
            @php
        $precio1 = 'Precio x unidad: $ '.$costoActual;     
        $precio6 = 'Precio x pack (6): $ '.$costoActual * 6;
        $precio24 = 'Precio x pack (24): $ '.$costoActual * 24; 
            @endphp
        @break

    @case($verProducto->unidadCompra == 'sixpack')
            @php
        $precio1 = 'Precio x unidad: $ '.$costoActual / 6;   
        $precio6 = 'Precio x pack (6): $ '.$costoActual;         
        $precio24 = 'Precio x pack (24): $ '.$costoActual * 4;   
            @endphp 
        @break

    @case($verProducto->unidadCompra == 'pack24')
            @php
        $precio1 = 'Precio x unidad: $ '.$costoActual / 24; 
        $precio6 = 'Precio x pack (6): $ '.$costoActual / 4;   
        $precio24 = 'Precio x pack (24): $ '.$costoActual;               
            @endphp
        @break

    @case($verProducto->unidadCompra == 'otro')    
            @php
        $precio1 = 'No se detecto la unidad de compra'; 
        $precio6 = 'Su valor de costo es de:';   
        $precio24 = '$ '.$costoActual;             
            @endphp
        @break
@endswitch 


<div class="container">
    <center> <a href="{{ route('wonderlist') }}" class="btn btn-info mb-3"> Volver al <b> Wonderlist </b>  </a> </center>

<h2 class="text-center"> {{ $verProducto->marca }} </h2>
<h3 class="text-center border-bottom"> {{ $verProducto->tipo }} </h3>
<p style="font-size:120%;"><b>Stock disponible:</b> {{ $verProducto->stock }} unidades</p>


<b style="font-size:120%;"> Precio de COSTO: </b>
<p> {{ $precio1 }}  <br>
    {{ $precio6 }}<br>
    {{ $precio24 }} </p>

<b style="font-size:120%;"> Precio para la venta:</b>
    <p class=""> Precio x unidad: $ {{ $verProducto->precioVenta }} <br>
     Precio x pack (6): $ {{ $verProducto->precioPack }}</p>

<p class=""> Categoria actual: {{ $verProducto->tipoCerveza }}
</div>


@endsection
@section('scripts')
<script src="/js/wonderlist.js"></script>
@endsection