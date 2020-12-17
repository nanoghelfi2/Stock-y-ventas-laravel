

  <div class="modal-body">
      <div id="parteUno">
          <button type="button" class="btn btn-primary btn-sm atajoTag" value="peñon"> Peñon </button>
          <button type="button" class="btn btn-primary btn-sm atajoTag" value="tacuara"> Tacuara </button>
          <button type="button" class="btn btn-primary btn-sm atajoTag" value="imperial"> Imperial </button>
          <button type="button" class="btn btn-primary btn-sm atajoTag" value="heineken"> Heineken </button>
          <input type="text" class="form-control mb-2 mt-2" value="Escribir..." id="inputBusqueda">                 
          <table class="table table-sm" id="mostrarProducto">
          </table>
      </div>
      <input type="hidden" id="prodEnCarro" value="me mostras?">
      <div id='datosBDD'> </div>
      <div id='datosBD'> </div>
      
      <div id="parteDos" class="d-none"> 
              <div class="">
                  <h5 class="text-center mt-2">Elija una unidad... </h5> 
                <center>
                  <button class="agregandoUnidad btn btn-primary btn-lg mr-4" value="unidad">   Unidad      </button>
                  <button class="agregandoUnidad btn btn-primary btn-lg" value="sixpack">  Pack x 6    </button>
                </center>

              </div>
              <input type="hidden" id="unidadSeleccionada" value="me mostras?"> 
      </div>
      <div id="parteTres" class="d-none"> 
              <div class="">
                  <h5 class="text-center mt-2">Cantidad:</h5> 
                    <div class="input-group align-items-center">
                  <button type="button" class="btn btn-dark" id="restar"><b style="font-size:110%"> - </b></button>
                        <input type="number" class="form-control mb-2 ml-4 mr-4" id="agregandoCantidad" min="1">
                  <button type="button" class="btn btn-dark" id="sumar"><b style="font-size:110%"> + </b></button>
                    </div>
                  <br> <b> Subtotal: </b> <span id="subtotal">  </span> 
              </div>
      </div>
  </div>

  
@section('scripts')
<script src="/js/chango.js"></script>
@endsection