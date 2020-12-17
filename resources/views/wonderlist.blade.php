@extends('layouts.app')
@section('tittle') Stock y precios @endsection

@section('content')
@if (session('success'))
<div class="alert alert-success d-flex justify-content-between align-items-center"> {{ session('success') }}  </div>
@endif

<div class="container mb-4">
    <a href="{{ route('wonderlist.agregar') }}" class="btn btn-success btn-block"> Agregar nuevo producto </a>
</div>

<div id="deseaBorrar" class="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

</div>


<div class="container mb-3 border-top border-bottom">
  <form action="wonderlist"></form>
  <p> Seleccione una marca: </p>
  <select name="" id="filtro-marca" class="form-control"> {{-- el ID select-marca, lo capto en edit.js --}}
    <option value="todas"> Todas </option>
          @foreach ($marcas as $select1)
    <option value="{{ $select1->marca }}"> {{ $select1->marca }} </option>                
          @endforeach
  </select>
  <a href="/wonderlist/filtro/todas" class="btn btn-primary btn-block mt-2 mb-2" id="anclaFiltro">
      Filtrar
  </a>
</div>

<div class="">
<table class="table table-striped ">
    <thead class="thead-dark">
      <tr>
        <th scope="col">Marca <br> Tipo </th>
        <th scope="col"> $ Unid. <br> $ Pack</th>
        <th scope="col"> Stock </th>
        <th scope="col"> Acciones </th>
      </tr>
    </thead>
    <tbody>
            @foreach ($productos as $item)
      <tr class="align-middle">
        <div>
          <th scope="row" class="align-middle"><a href="{{ route ('wonderlist.ver', $item->id)}}"> <b> {{ $item->marca}} </b><br> {{ $item->tipo}} </a></th>
          <td class="align-middle">$ {{ $item->precioVenta}} <br> $ {{ $item->precioPack}} </td> 
          <td class="text-center align-middle">{{ $item->stock}}</td>
          <td> 
              <a href="{{ route('wonderlist.editar', $item->id)}}" class="btn-sm btn-warning btn-block text-center"> 
                  Editar 
              </a> 
        
              <button class="btn-sm btn-danger btn-block text-center botonBorrar" value="{{ $item->id }}" data-toggle="modal" data-target="#deseaBorrar">
                Borrar 
              </button>
          </td>
      </tr>
            @endforeach
    </tbody>
  </table>
</div>




@endsection

@section('scripts')
<script src="/js/pruebas/edit.js"></script>
<script src="/js/wonderlist.js"></script>
@endsection