@extends('layouts.app')
@section('tittle') Agregar producto @endsection
@section('content')
<center> <a href="{{ route('wonderlist') }}" class="btn btn-info mb-3"> Volver al <b> Wonderlist </b>  </a> </center>

<h3 class="text-center border-bottom border-top"> Agregar un nuevo producto </h3>


<form action="{{ route('agregar.enviar') }}" method="POST" style="margin-bottom:30%;"> 
@csrf  

@if (session('success'))
    <div class="alert alert-success d-flex justify-content-between align-items-center"> {{ session('success') }}  
    <a href="{{ route('wonderlist') }}" class="btn btn-success"> Volver al Wonderlist </a></div>
@endif

@if (session('Error'))
    <div class="alert alert-danger"> {{ session('Error') }} </div>
@endif

@error('existenteMarca')
    <div class="alert alert-danger"> Debe seleccionar una Marca </div>  
@enderror
@error('nuevoTipo')
    <div class="alert alert-danger"> Debe escribir un Tipo </div>  
@enderror


<div class="container mt-3 border-bottom border-secondary">
    <div class="form-group">
    <h4> Marca: </h4>

        <b>Seleccione una marca existente: </b>
        <select class="form-control"  name="existenteMarca" id="marcaExistente"> 
            <option value=""  ></option>
                @foreach ($marcas as $item)
            <option value="{{ $item->marca }}"> {{ $item->marca }} </option>  
                @endforeach
        </select>

        <b>O escriba una nueva marca:</b>
        <input type="text" class="form-control"  name="nuevaMarca" value="{{ old('nuevaMarca') }}"> 

    </div>
</div>

<div class="container mt-2 mb-2 border-bottom border-secondary">  
        <div class="form-group">
        <h4> Tipo: </h4>
            <b>Escriba un tipo:</b>
            <input type="text" class="form-control" name="nuevoTipo" value="{{ old('nuevoTipo') }}"> 

        </div>
</div>

<div class="container">
        <div class="form-group mb-3">


            <b>Precio de costo:</b>
            <input type="number" class="form-control" name="precioCompra" value="{{ old('precioCompra') }}"> 

            <select class="form-control mb-3" name="unidadCompra"> 
                <option value="" > Seleccione una unidad </option>
                <option value="unidad">     Unidad </option>
                <option value="sixpack">    Pack de 6 </option>
                <option value="pack24">     Pack de 24 </option>
                <option value="otro">     Otro </option>
            </select>


        </div>
        <div class="form-group mt-4">

            <b>Precio venta por unidad:</b>
            <input type="number" class="form-control mb-4" name="precioVenta" id="inputPrecioUnidad" value="{{ old('precioVenta') }}" min="0"> 

            <b>Precio venta por pack (x 6):</b>
            <input type="number" class="form-control mb-4" name="precioPack" id="inputPrecioPack" value="{{ old('precioPack') }}" min="0"> 

            <b>Stock:</b>
            <input type="number" class="form-control mb-4" name="stock" value="{{ old('stock') }}" min="0"> 

            <b>Tipo:</b>
            <select class="form-control" name="tipoCerveza"> 
                <option value=""> Seleccione un estilo de producto </option>
                <option value="artesanal"> Artesanal </option>
                <option value="industrial"> Industrial </option>
                <option value="otro"> Otros </option>
            </select>

            
        </div>
</div>
<center><button class="btn btn-primary btn-lg" type="submit"> Agregar producto </button></center>
</form>
@endsection

@section('scripts')
<script src="/js/wonderlist.js"></script>
@endsection
