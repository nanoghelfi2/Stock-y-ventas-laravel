//Filtro en wonderlist
$(function(){
    $('#filtro-marca').on('change', onSelectMarca); 
});


function onSelectMarca(){
    var filtroMarca = $(this).val();
    $('#anclaFiltro').attr("href", '/wonderlist/filtro/'+filtroMarca);

}

//Funcion para autocalcular el precio pack
$(function(){
    $('#inputPrecioUnidad').on('change', multiplicadorPack); 
});
function multiplicadorPack(){
    var precioUnidad = $(this).val();
    var resultado = precioUnidad * 6;

    $('#inputPrecioPack').val(resultado);
    console.log('me multiplico: '+resultado);

}




//BORRAR PRODUCTO
$(function(){
    $('.botonBorrar').on('click',mostrarID); //Cuando el select de ID selec-project cambie, se ejecute la funcion onSelectProjectChange
});

function mostrarID(){
    let id = $(this).val();
    const traerDatos = '/wonderlist/modal/'+id;

    $.get(traerDatos, function(data){
        var modal = '<div class="container">'+data+'</div>'
        $('#deseaBorrar').html(modal); 
        console.log('me ejecuto con: '+data);
    })

}



