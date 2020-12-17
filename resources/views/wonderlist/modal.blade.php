
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">¿Seguro que quiere borrar este producto?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
        @foreach ($productoEliminar as $item)
        <b> {{ $item->marca }}</b> <br>
          <p>{{ $item->tipo }}</p>

        @endforeach
        </div>
        <div class="modal-footer">
          <a href="{{ route('wonderlist') }}" class="btn btn-secondary">No</a>

          <form action="{{ route('wonderlist.borrar', $item->id)}}" method="POST">
            @method('DELETE')
            @csrf
            <button class="btn btn-danger" type="submit">Si, Borrar</button> 
          </form>

        </div>
      </div>
    </div>
  </div>