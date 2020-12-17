@extends('layouts.app')
@section('tittle') Clientes @endsection

@section('content')
@if (session('success'))
<div class="alert alert-success d-flex justify-content-between align-items-center"> {{ session('success') }}  </div>
@endif
@if (session('danger'))
<div class="alert alert-danger d-flex justify-content-between align-items-center"> {{ session('danger') }}  </div>
@endif

<h2 class="text-center">Lista de clientes</h2>

<p class="text-center"> Click en <b>"Ver mas"</b> para poder <b>VER, EDITAR y BORRAR </b> toda su informacion. </p>

<center>
<button class="btn btn-success btn-lg mb-4" data-toggle="modal" data-target="#agregarNuevo"> 
  Agregar nuevo cliente 
</button>
</center>

<div class="container">
    @foreach ($allClientes as $client)

        <div class="p-3 mb-2 bg-primary text-white
        d-flex justify-content-between">
            <div>
                <b>{{ $client->nombreCliente }}</b> <br> {{ $client->lugar }}  
            </div>
            <button type="button" class="btn btn-light verModal" value="{{ $client->id }}"
            data-toggle="modal" data-target="#modalCliente"> 
                Ver mas 
            </button>
        </div>
 
    @endforeach
</div>

{{-- MODAL DETALLE --}}
<div class="modal fade" id="modalCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" id="contenedorModal">


      </div>
    </div>
  </div>

{{-- MODAL AGREGAR NUEVO --}}
  <div class="modal fade" id="agregarNuevo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Agregar cliente</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body"> 
          <center>
            <b> Los campos que tengan * son obligatorios </b>
            <form action="{{ route('cliente.agregar') }}" method="POST">
              @csrf
              *Nombre: <br>
              <input type="text" name="nombre" class="form-control" required><br>
              *Localidad: <br>
              <input type="text" name="lugar" class="form-control" required><br>
              Calle(s): <br>
              <input type="text" name="lugarDos" class="form-control"><br>
              Contacto: <br>
              <input type="text" name="contacto" class="form-control"><br>
              Contacto 2: <br>
              <input type="text" name="contactoDos" class="form-control"><br>
          </center>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-success" id="btnAgregarCl">¡Agregar!</button>
          <button type="button" class="btn btn-secondary d-none" id="btnAgregarClRemplazo">Agregando...</button>
            </form>
        </div>
      </div>
    </div>
  </div>


@endsection

@section('scripts')
<script src="/js/cliente.js"></script>
@endsection