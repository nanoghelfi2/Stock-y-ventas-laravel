
//Boton de chango nuevo
$(function(){
    $('#botonNewChango').on('click', buscarNuevoId); 
});

function buscarNuevoId(){
    const buscaID = '/chango/crearChango/nuevoChango';
    $.get(buscaID, function(data){
    
    $(location).attr('href','/chango/'+data);
})
}

//Funcionalidad Descuento
$(function(){
    $('#numero').on('change', descuento);
    $('#numero').keyup(descuento);
    $('#tipo').on('change', descuento);

    function descuento(){
        //Variables 
        let numero = $('#numero').val();
        let tipo = $('#tipo').val();
        let precioFinal = $('#precioTotal').val()
        let porcentual = numero / 100;

        let boton = $('#botonDescontar')
        let resultadoText = $('#colocar')
        let msj = $('#msj')

        console.log(boton.get(0).type);
        //Cuentas para aplicar descuento
        switch(tipo){
            case '-':
                descuentoT = numero;
                break;   
            case '+':
                descuentoT = -numero;
                break;
            case '-%':
                descuentoT =  (precioFinal * porcentual);
                if(numero > 100){
                    boton.removeClass('btn-primary');
                    boton.addClass('btn-secondary');
                    boton.get(0).type = 'button';
                    msj.removeClass('d-none')
                    msj.html('<p class="text-danger">No puede aplicar un descuento de mas del 100%</p>')
                }else{
                    boton.removeClass('btn-secondary');
                    boton.addClass('btn-primary');
                    boton.get(0).type = 'submit';
                    msj.addClass('d-none') }
                break;
            case '+%':
                descuentoT =  -(precioFinal * porcentual) ;
                break;
        }
        //Comprobaciones 
        if(numero < 0){
            boton.removeClass('btn-primary');
            boton.addClass('btn-secondary');
            boton.get(0).type = 'button';
            msj.removeClass('d-none')
            msj.html('<p class="text-danger"> El numero ingresado es negativo. </p>')
        }else{
            boton.removeClass('btn-secondary');
            boton.addClass('btn-primary');
            boton.get(0).type = 'submit';
            msj.addClass('d-none') }

        resultado = precioFinal - descuentoT; 
        resultadoText.html(resultado);

        $('#resultadoFinal').val(descuentoT)
    }
});





/*        ->  FUNCIONALIDAD DE AGREGAR PRODUCTO AL CHANGO <-
    1) Captamos cuando hacemos click en el boton "agregar producto", con este, traemos el modal de "modalNP.blade.php" -> Esto hace que no tengamos que recargar la pagina si nos equivocamos y necesitemos agregar nuevamente un producto
    2) Al abrirse el modal, escribimos fragmento, por ejemplo, la marca del producto que necesitemos y lo seleccionamos
    2.1) Al seleccionar un producto, recuperamos de otra URL, los datos de este producto (como por ejemplo el precio y el stock) y asi poder utilizarlos
    3) En esta instancia, tendremos que elegir entre si es una "unidad" o "pack", si no elegimos, no podremos avanzar
    4) Al elegir una unidad, se nos avilita la opcion de escribir una cantidad, la cual se multiplica por la unidad que elegimos anteriormente
    5) Una vez escrita la cantidad, ya se nos abilita la opcion de agregar el producto                 */


$(function(){
    $('#btnAgregarProducto').on('click', function(){ //Detectamos el click del boton agregar producto
    const urlModal = '/chango/modal/modalNP'; //URL del modal
    $.get(urlModal, function(data){ 
        var modal = data;
        $('#cuerpoModal').html(modal);  //Lo buscamos y lo pegamos en el div #cuerpoModal, de la pag ppal


    if($('#parteTres').hasClass('d-none')){ //Si la parte 3 esta oculto, tambien lo tiene que estar el boton de enviar formulario.
        $('#enviarFormProducto').addClass('d-none');
    }
  
    //input text del modal para busqueda de producto
    let inputBusqueda = $('#inputBusqueda') 
    inputBusqueda.on('click', function(){  $(this).val('')  }); //Al hacer click en el input, el value se vuelve vacio para poder escribir

    //Aca le damos un valor para que busque en la bbdd las cervezas segun lo que escribamos
    $('.atajoTag').on('click', buscarProducto);
    inputBusqueda.on('change', buscarProducto);  
    inputBusqueda.keyup(buscarProducto);   

    function buscarProducto(){  
        var busqueda = $(this).val(); //obtenemos el valor que buscamos
        const newLocal = '/wonderlist/pruebas/'+busqueda+'/tipos'; // Y lo llevamos a esta url para obtener los datos con AJAX
        $.get(newLocal, function(data){
            var muestraProducto = ''
            for (let i = 0; i < data.length; i++)
            muestraProducto += '<thead><tr id="cambioColor"><th scope="col">'+data[i].marca+'</th><th scope="col">'+data[i].tipo+'</th><th scope="col"><button class="boton-seleccionar btn btn-primary btn-sm" value="'+data[i].id+'"> Seleccionar </button></th></tr></thead>'
            $('#mostrarProducto').html(muestraProducto); //Colocamos los datos del producto en nuestro modal


            $('.boton-seleccionar').on('click', mostrarMas); //detecta el boton que seleccionamos
            function mostrarMas(){
                var idProducto = $(this).val();
                $('#parteUno').addClass('d-none');
                $('#parteDos').removeClass('d-none');


                //Todo el siguiente bloque hasta FIN, 
                //ES para traer datos de la BD y mostrarlo en el div #parteDos 
                var idChango = $('#idChango').val();
                const traerCarrito = '/chango/buscar/'+idChango+'/'+idProducto;
                $.get(traerCarrito, buscarDatos);
                function buscarDatos(datos){
                    if(datos.cantidadEnChango > 0){
                        var textoPA = '<p class="text-danger"> Se encontro <b>'+ datos.cantidadEnChango + '</b> de este producto en el carro actual </p>';
                        $('#datosBDD').html(textoPA);    
                    }  
                    $('#prodEnCarro').val(datos.cantidadEnChango);            
                }                
                const traerID = '/wonderlist/productoPorID/'+idProducto;                
                $.get(traerID, function(dataID){
                        
                        for (let i = 0; i < dataID.length; i++){
                        var precioVenta = dataID[i].precioVenta;
                        var precioPack =  dataID[i].precioPack;
                        var idProd = dataID[i].id;
                        var stockActual = dataID[i].stock;
                        
                        var yaExistente = $('#prodEnCarro').val();
                        let estadoVenta = $('#estadoVenta').val();

                        if(estadoVenta == 'proceso'){
                            mostrarStock = stockActual;
                            stockActual = stockActual - yaExistente; 
                        }                        

                        if (yaExistente > 0 & estadoVenta == 'proceso'){
                            datoMarca = '<b>Id del producto:</b>'+dataID[i].id+'<br><b>Marca:</b> '+dataID[i].marca+'<br><b>Tipo:</b>'+dataID[i].tipo+'<br><b>Precio unitario:</b> $'+dataID[i].precioVenta+'<br><b>Precio por pack:</b> $'+dataID[i].precioPack+'<br> <span id="stockActual"><b>Stock actual:</b>'+mostrarStock+'</span><span class="text-danger"> -'+yaExistente+'</span>';    
                        }else{
                            datoMarca = '<b>Id del producto:</b>'+dataID[i].id+'<br><b>Marca:</b> '+dataID[i].marca+'<br><b>Tipo:</b>'+dataID[i].tipo+'<br><b>Precio unitario:</b> $'+dataID[i].precioVenta+'<br><b>Precio por pack:</b> $'+dataID[i].precioPack+'<br> <span id="stockActual"><b>Stock actual:</b>'+stockActual+'</span>';
                        }
                        $('#datosBD').html(datoMarca); }
                        //////////////////////          FIN         ////////////////////
                                        
                        
                       //Funcionalidad para elegir la unidad
                    $('.agregandoUnidad').on('click', function(){    //tenemos 2 botones para elegir, y lo captamos con su clase
                        var unidadesSelect = $(this).val();          //Captamos el "value" al cual le hicimos click   

                                if(unidadesSelect == 'unidad'){
                                    var unidadesText = 'Unidad';
                                }else if(unidadesSelect == 'sixpack'){
                                    var unidadesText = 'Pack x 6';}
                        datoMarca += '<br><b>Unidad: </b>'+ unidadesText;
                        $('#datosBD').html(datoMarca); //Mostramos un texto en el modal haciendo referencia a la unidad que elegimos

                        $('#unidadSeleccionada').val(unidadesSelect); //Le cambiamos el value a un input hidden para poder utilizarlo mas abajo
                        
                        $('#parteDos').addClass('d-none');    //Y activamos el siguiente paso o parte (Se activa la accion de elegir cantidad)
                        $('#parteTres').removeClass('d-none');
                    });   
                   

                    
                    $('#agregandoCantidad').keyup(multiplicador);
                    $('#agregandoCantidad').on('change', multiplicador);
                    $('#agregandoCantidad').attr({"max": stockActual, "min": 1});

                                        //BOTONES DE SUMAR Y RESTAR 
                                        $('#sumar').on('click', sumar);
                                        function sumar(){
                                            valor = Number($('#agregandoCantidad').val());
                                            num = 1;
                                            if(valor == parseInt($('#agregandoCantidad').attr('max'))){
                                                num = 0; }
                                            $('#agregandoCantidad').val(valor + num).change(); }
                    
                                        $('#restar').on('click', restar);
                                        function restar(){
                                            valor = Number($('#agregandoCantidad').val());
                                            num = 1;
                                            if(valor == parseInt($('#agregandoCantidad').attr('min'))){
                                                num = 0; }
                                            $('#agregandoCantidad').val(valor - num).change();  }


                    function multiplicador(){

                        $('#enviarFormProducto').removeClass('d-none');
                        var cantidadEscrita = $(this).val();
                        var unidades = $('#unidadSeleccionada').val();  

                                if(unidades == 'unidad'){
                                    var unidadFinal = 1;
                                    var cantidadEscrita2 = cantidadEscrita;
                                    var precioCuenta = precioVenta;
                                }else if(unidades == 'sixpack'){
                                    var unidadFinal = 1;
                                    var cantidadEscrita2 = cantidadEscrita * 6;
                                    var precioCuenta = precioPack;
                                }
                                
                                //La siguiente funcion IF, es para comprobar que no agreguemos mas productos que el stock
                                if(cantidadEscrita2 > stockActual || cantidadEscrita2 < 0){
                                    $('#enviarFormProducto').addClass('d-none');
                                    $('#stockActual').addClass('text-danger');
                                    $('#agregandoCantidad').addClass('text-danger');
                                }else{
                                    $('#stockActual').removeClass('text-danger');
                                    $('#enviarFormProducto').removeClass('d-none');
                                    $('#agregandoCantidad').removeClass('text-danger');
                                }

                                                         
                                
                        var resultado = cantidadEscrita * precioCuenta * unidadFinal; //Subtotal escrito en el modal
                        $('#subtotal').html('$ '+resultado);


                        //A continuacion, creo variables con los inputs hidden, donde almaceno en su value, la informacion para agregar un producto
                                //Y lo insertamos en el html "chango.blade.php" para enviarlo como formulario a su controlador
                        var inputStock = '<input type="hidden" name="stockActual" value="'+stockActual+'">';
                        var inputCantidad = '<input type="hidden" name="cantidad" value="'+cantidadEscrita+'">';
                        var inputUnidad = '<input type="hidden" name="unidades" value="'+unidades+'">';
                        var inputSubtotal = '<input type="hidden" name="subtotal" value="'+resultado+'">';
                        var inputIdProd = '<input type="hidden" name="idProducto" value="'+idProd+'">'
                        $('#inputHidden').html(inputCantidad+inputUnidad+inputSubtotal+inputIdProd+inputStock);

                        $('#enviarFormProducto').on('click', function(){
                            $('#enviarFormProducto').addClass('d-none');
                            $('#remplazoEnviar').removeClass('d-none');
                        });

                        }//Cierra funcion multiplicador
                    })//Cierra la funcion donde traemos los datos del chango segun su ID
                }//Cerramos la funcion MostrarMas
            });//Cerramos la funcion donde mostramos los datos de productos
        }//Cerramos la funcion buscar producto
    });
}) //Cierra la busqueda del modal en "/chango/modal/modalNP"
}); //Cierra el function principal


//Botones para evitar que se envie varias veces los formularios
$('.btnBorrar').on('click', function(){
    $(this).addClass('d-none')
});

$('#btnFinal').on('click', function(){
    $(this).addClass('d-none')
    $('#btnFinalRemplazo').removeClass('d-none')
});

$('#btnCancelarVenta').on('click', function(){
    $(this).addClass('d-none')
    $('#btnCancelarVentaRemplazo').removeClass('d-none')
});