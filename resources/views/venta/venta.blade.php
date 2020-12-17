

<div class="modal-header">
@foreach($verVenta as $vv)
      <h5 class="modal-title" id="exampleModalLabel">ID de la venta: {{ $vv->id }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

      <h5> Cliente: {{ $vv->nombreCliente }} </h5>
        <div style="font-size:110%;">
            <b> Fecha: </b> {{ $vv->fecha }} <br>
            <b> Lugar de entrega: </b> {{ $vv->lugar }} <br>
            <b> Valor total: $ {{ $vv->valorVenta }}</b> <br>
            <center> <b> Productos: </b> <br> @php  echo $vv->productosVendidos @endphp </center>
@endforeach   
        </div>
      </div>



