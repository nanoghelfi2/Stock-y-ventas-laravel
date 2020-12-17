@foreach ($mostrarCliente as $as)
@php
  $idCliente = $as->id; 
@endphp

<div class="modal-header">
    <form action="{{route('cliente.borrar', $idCliente)}}" method="POST">
      @csrf
      @method('DELETE')
      <button type="submit" class="btn btn-danger mr-4">Borrar cliente</button>
    </form>

    <h5 class="modal-title align-middle mt-2" id="exampleModalLabel">Datos del cliente</h5> 

    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>

<form action="{{route('cliente.editar', $idCliente)}}" method="POST">
@csrf
@method('PUT')
  <div class="modal-body">
    <b>Nombre:</b>      <input type="text" name="nombre" value="{{ $as->nombreCliente }}" class="form-control"> <br>
    <b>Contacto:</b>    <input type="text" name="contacto" value="{{ $as->contacto }}" class="form-control">      <br>
    <b>Contacto 2:</b>  <input type="text" name="contactoDos" value="{{ $as->contactoDos }}" class="form-control">   <br>
    <b>Localidad:</b>   <input type="text" name="lugar" value="{{ $as->lugar }}" class="form-control">         <br>
    <b>Calles:</b>      <input type="text" name="lugarDos" value="{{ $as->lugarDos }}" class="form-control">
  </div>
  <div class="modal-footer">

    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

    <button type="submit" class="btn btn-warning" value="{{ $as->id }}">Editar </button>
    </form>


  </div>


@endforeach